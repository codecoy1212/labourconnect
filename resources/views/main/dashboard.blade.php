@extends('scripts')

@section('up_title', 'Dashboard')
@section('first_ref', 'Dashboard')
@section('pg_act', 'breadcrumb--active')
@section('pg_act_da', 'side-menu--active')

<?php $add = route('dash');?>
@section('first_add',$add)

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="text-center col-span-12 mt-8">
                {{-- <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Dashboard
                    </h2>
                    <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                </div> --}}
                <div class="grid grid-cols-12 gap-6 mt-5 xl:ml-20 xl:mr-20">
                    <a class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y" href="{{route('aser')}}">
                        <div class="zoom-in">
                            <div class="box p-6 border-theme-1 border-2">
                                <div class="flex">
                                    <i style="width:43px; height:43px;" data-feather="user" class="report-box__icon text-theme-1 m-auto"></i>
                                </div>
                                <div class="text-gxl font-bold leading-8 mt-6">Add New User</div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y" href="{{route('cies')}}">
                        <div class="zoom-in">
                            <div class="box p-6 border-theme-1 border-2">
                                <div class="flex">
                                    <i style="width:43px; height:43px;" data-feather="layers" class="report-box__icon text-theme-1 m-auto"></i>

                                </div>
                                <div class="text-gxl font-bold leading-8 mt-6">Add New Company</div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y" href="{{route('oles')}}">
                        <div class="zoom-in">
                            <div class="box p-6 border-theme-1 border-2">
                                <div class="flex">
                                    <i style="width:43px; height:43px;" data-feather="users" class="report-box__icon text-theme-1 m-auto"></i>

                                </div>
                                <div class="text-gxl font-bold leading-8 mt-6">Create Role</div>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="grid grid-cols-12 gap-6 mt-10 xl:ml-40">
                    <a class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y" href="{{route('orts')}}">
                        <div class="zoom-in">
                            <div class="box p-6 border-theme-1 border-2">
                                <div class="flex">
                                    <i style="width:43px; height:43px;" data-feather="file-text" class="report-box__icon text-theme-1 m-auto"></i>
                                </div>
                                <div class="text-gxl font-bold leading-8 mt-6">Reports</div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y" href="{{route('njob')}}">
                        <div class="zoom-in">
                            <div class="box p-6 border-theme-1 border-2">
                                <div class="flex">
                                    <i style="width:43px; height:43px;" data-feather="briefcase" class="report-box__icon text-theme-1 m-auto"></i>

                                </div>
                                <div class="text-gxl font-bold leading-8 mt-6">Create Job</div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>


@endsection()
