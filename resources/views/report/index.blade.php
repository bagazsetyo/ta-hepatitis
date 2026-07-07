@extends('layouts.app')
    @section('report', 'active')
@section('content')
<div class="row">
    <section class="col-lg-7 connectedSortable">
        <div class="nav-tabs-custom">
           <ul class="nav nav-tabs pull-right">
              <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
              <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
            </div>
        </div>
    </section>
    <section class="col-lg-5 connectedSortable">
        <div class="box box-solid bg-light-blue-gradient">
            <div class="box-header">
                <div class="pull-right box-tools">
            
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

