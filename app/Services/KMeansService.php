<?php

namespace App\Services;

class KMeansService
{
    public function clusterPatients($patients, $symptoms, $patientSymptoms, $patientDiagnoses, int $requestedK = 5, int $maxIterations = 100): array
    {
        $symptomIds = $symptoms->pluck('id')->values()->all();
        $symptomNames = $symptoms->pluck('gejala', 'id')->all();
        $symptomsByPatient = $this->groupValues($patientSymptoms, 'idpasien', 'idgejala');
        $diagnosesByPatient = $this->groupValues($patientDiagnoses, 'idpasien', 'penyakit');

        $samples = [];
        $excludedPatients = [];

        foreach ($patients as $patient) {
            $selectedSymptoms = $symptomsByPatient[$patient->id] ?? [];
            $vector = [];

            foreach ($symptomIds as $symptomId) {
                $vector[] = in_array($symptomId, $selectedSymptoms, true) ? 1.0 : 0.0;
            }

            if (array_sum($vector) === 0.0) {
                $excludedPatients[] = [
                    'id' => $patient->id,
                    'nama' => $patient->nama_lengkap,
                    'alasan' => 'Belum memiliki data gejala hasil diagnosis',
                ];
                continue;
            }

            $samples[] = [
                'id' => $patient->id,
                'nama' => $patient->nama_lengkap,
                'vector' => $vector,
                'gejala_ids' => $selectedSymptoms,
                'diagnosis' => $diagnosesByPatient[$patient->id] ?? [],
            ];
        }

        if (count($samples) === 0) {
            return $this->emptyResult($requestedK, $symptomIds, $excludedPatients);
        }

        $k = max(1, min($requestedK, count($samples)));
        $centroids = $this->initialCentroids($samples, $k);
        $assignments = array_fill(0, count($samples), null);
        $iterations = [];

        for ($iteration = 1; $iteration <= $maxIterations; $iteration++) {
            $newAssignments = $this->assignSamples($samples, $centroids);
            $iterations[] = [
                'iteration' => $iteration,
                'assignments' => $this->assignmentCounts($newAssignments, $k),
                'centroids' => $centroids,
            ];

            if ($newAssignments === $assignments && $iteration > 1) {
                break;
            }

            $assignments = $newAssignments;
            $centroids = $this->recalculateCentroids($samples, $assignments, $centroids, $k);
        }

        $clusters = $this->buildClusters($samples, $assignments, $centroids, $k, $symptomNames);

        return [
            'requested_k' => $requestedK,
            'actual_k' => $k,
            'feature_count' => count($symptomIds),
            'sample_count' => count($samples),
            'excluded_patients' => $excludedPatients,
            'clusters' => $clusters,
            'initial_centroids' => $this->initialCentroids($samples, $k),
            'final_centroids' => $centroids,
            'iterations' => $iterations,
            'silhouette_score' => $this->silhouetteScore($samples, $assignments, $k),
            'davies_bouldin_index' => $this->daviesBouldinIndex($samples, $assignments, $centroids, $k),
        ];
    }

    private function emptyResult(int $requestedK, array $symptomIds, array $excludedPatients): array
    {
        return [
            'requested_k' => $requestedK,
            'actual_k' => 0,
            'feature_count' => count($symptomIds),
            'sample_count' => 0,
            'excluded_patients' => $excludedPatients,
            'clusters' => [],
            'initial_centroids' => [],
            'final_centroids' => [],
            'iterations' => [],
            'silhouette_score' => null,
            'davies_bouldin_index' => null,
        ];
    }

    private function groupValues($rows, string $groupKey, string $valueKey): array
    {
        $grouped = [];

        foreach ($rows as $row) {
            $groupValue = $row->{$groupKey};
            $value = $row->{$valueKey};

            if (!isset($grouped[$groupValue])) {
                $grouped[$groupValue] = [];
            }

            if (!in_array($value, $grouped[$groupValue], true)) {
                $grouped[$groupValue][] = $value;
            }
        }

        return $grouped;
    }

    private function initialCentroids(array $samples, int $k): array
    {
        $centroids = [$samples[0]['vector']];

        while (count($centroids) < $k) {
            $bestSample = null;
            $bestDistance = -1.0;

            foreach ($samples as $sample) {
                $nearestDistance = min(array_map(function ($centroid) use ($sample) {
                    return $this->distance($sample['vector'], $centroid);
                }, $centroids));

                if ($nearestDistance > $bestDistance) {
                    $bestDistance = $nearestDistance;
                    $bestSample = $sample;
                }
            }

            $centroids[] = $bestSample['vector'];
        }

        return $centroids;
    }

    private function assignSamples(array $samples, array $centroids): array
    {
        $assignments = [];

        foreach ($samples as $sampleIndex => $sample) {
            $nearestCluster = 0;
            $nearestDistance = null;

            foreach ($centroids as $clusterIndex => $centroid) {
                $distance = $this->distance($sample['vector'], $centroid);

                if ($nearestDistance === null || $distance < $nearestDistance) {
                    $nearestDistance = $distance;
                    $nearestCluster = $clusterIndex;
                }
            }

            $assignments[$sampleIndex] = $nearestCluster;
        }

        return $assignments;
    }

    private function recalculateCentroids(array $samples, array $assignments, array $currentCentroids, int $k): array
    {
        $newCentroids = $currentCentroids;
        $featureCount = count($samples[0]['vector']);

        for ($clusterIndex = 0; $clusterIndex < $k; $clusterIndex++) {
            $members = [];

            foreach ($samples as $sampleIndex => $sample) {
                if ($assignments[$sampleIndex] === $clusterIndex) {
                    $members[] = $sample;
                }
            }

            if (count($members) === 0) {
                continue;
            }

            $centroid = array_fill(0, $featureCount, 0.0);

            foreach ($members as $member) {
                foreach ($member['vector'] as $featureIndex => $value) {
                    $centroid[$featureIndex] += $value;
                }
            }

            foreach ($centroid as $featureIndex => $value) {
                $centroid[$featureIndex] = $value / count($members);
            }

            $newCentroids[$clusterIndex] = $centroid;
        }

        return $newCentroids;
    }

    private function buildClusters(array $samples, array $assignments, array $centroids, int $k, array $symptomNames): array
    {
        $clusters = [];

        for ($clusterIndex = 0; $clusterIndex < $k; $clusterIndex++) {
            $members = [];
            $symptomFrequency = [];
            $diagnosisFrequency = [];

            foreach ($samples as $sampleIndex => $sample) {
                if ($assignments[$sampleIndex] !== $clusterIndex) {
                    continue;
                }

                $members[] = $sample;

                foreach ($sample['gejala_ids'] as $symptomId) {
                    $symptomFrequency[$symptomId] = ($symptomFrequency[$symptomId] ?? 0) + 1;
                }

                foreach ($sample['diagnosis'] as $diagnosis) {
                    $diagnosisFrequency[$diagnosis] = ($diagnosisFrequency[$diagnosis] ?? 0) + 1;
                }
            }

            arsort($symptomFrequency);
            arsort($diagnosisFrequency);

            $dominantSymptoms = [];
            foreach (array_slice($symptomFrequency, 0, 5, true) as $symptomId => $count) {
                $dominantSymptoms[] = [
                    'id' => $symptomId,
                    'gejala' => $symptomNames[$symptomId] ?? 'Gejala tidak ditemukan',
                    'jumlah' => $count,
                    'persentase' => count($members) > 0 ? round(($count / count($members)) * 100, 2) : 0,
                ];
            }

            $clusters[] = [
                'cluster' => $clusterIndex + 1,
                'member_count' => count($members),
                'members' => $members,
                'dominant_symptoms' => $dominantSymptoms,
                'diagnosis_distribution' => $diagnosisFrequency,
                'centroid' => $centroids[$clusterIndex],
            ];
        }

        return $clusters;
    }

    private function assignmentCounts(array $assignments, int $k): array
    {
        $counts = array_fill(0, $k, 0);

        foreach ($assignments as $clusterIndex) {
            $counts[$clusterIndex]++;
        }

        return $counts;
    }

    private function silhouetteScore(array $samples, array $assignments, int $k): ?float
    {
        if (count($samples) < 2 || $k < 2) {
            return null;
        }

        $scores = [];

        foreach ($samples as $sampleIndex => $sample) {
            $ownCluster = $assignments[$sampleIndex];
            $sameClusterDistances = [];
            $otherClusterDistances = array_fill(0, $k, []);

            foreach ($samples as $otherIndex => $otherSample) {
                if ($sampleIndex === $otherIndex) {
                    continue;
                }

                $distance = $this->distance($sample['vector'], $otherSample['vector']);
                $otherCluster = $assignments[$otherIndex];

                if ($otherCluster === $ownCluster) {
                    $sameClusterDistances[] = $distance;
                } else {
                    $otherClusterDistances[$otherCluster][] = $distance;
                }
            }

            $a = count($sameClusterDistances) > 0 ? array_sum($sameClusterDistances) / count($sameClusterDistances) : 0.0;
            $b = null;

            foreach ($otherClusterDistances as $distances) {
                if (count($distances) === 0) {
                    continue;
                }

                $averageDistance = array_sum($distances) / count($distances);
                $b = $b === null ? $averageDistance : min($b, $averageDistance);
            }

            if ($b === null || max($a, $b) == 0.0) {
                $scores[] = 0.0;
                continue;
            }

            $scores[] = ($b - $a) / max($a, $b);
        }

        return round(array_sum($scores) / count($scores), 4);
    }

    private function daviesBouldinIndex(array $samples, array $assignments, array $centroids, int $k): ?float
    {
        if (count($samples) < 2 || $k < 2) {
            return null;
        }

        $scatter = array_fill(0, $k, 0.0);
        $counts = array_fill(0, $k, 0);

        foreach ($samples as $sampleIndex => $sample) {
            $clusterIndex = $assignments[$sampleIndex];
            $scatter[$clusterIndex] += $this->distance($sample['vector'], $centroids[$clusterIndex]);
            $counts[$clusterIndex]++;
        }

        foreach ($scatter as $clusterIndex => $value) {
            $scatter[$clusterIndex] = $counts[$clusterIndex] > 0 ? $value / $counts[$clusterIndex] : 0.0;
        }

        $ratios = [];

        for ($i = 0; $i < $k; $i++) {
            if ($counts[$i] === 0) {
                continue;
            }

            $maxRatio = null;

            for ($j = 0; $j < $k; $j++) {
                if ($i === $j || $counts[$j] === 0) {
                    continue;
                }

                $centroidDistance = $this->distance($centroids[$i], $centroids[$j]);
                if ($centroidDistance == 0.0) {
                    continue;
                }

                $ratio = ($scatter[$i] + $scatter[$j]) / $centroidDistance;
                $maxRatio = $maxRatio === null ? $ratio : max($maxRatio, $ratio);
            }

            if ($maxRatio !== null) {
                $ratios[] = $maxRatio;
            }
        }

        if (count($ratios) === 0) {
            return null;
        }

        return round(array_sum($ratios) / count($ratios), 4);
    }

    private function distance(array $a, array $b): float
    {
        $sum = 0.0;

        foreach ($a as $index => $value) {
            $difference = $value - ($b[$index] ?? 0.0);
            $sum += $difference * $difference;
        }

        return sqrt($sum);
    }
}
