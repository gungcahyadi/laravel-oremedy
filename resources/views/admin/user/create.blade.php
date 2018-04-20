@extends('layouts.back')

@section('conten')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ route('user.index') }}"><span>Manage Admin</span></a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Add New</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Add New Admin</h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> New Admin</span>
                    </div>

                </div>
                <div class="portlet-body">
                    {!! Form::open(['route' => 'user.store'])!!}
                    @include('admin.user._form')
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection