@extends('scripts')

@section('up_title', 'Jobs')
@section('first_ref', 'Jobs')
@section('pg_act', 'breadcrumb--active')
@section('pg_act_jo', 'side-menu--active')

<?php $add = route('jobs');?>
@section('first_add',$add)

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="text-center col-span-12 mt-4">
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mg-20">
                    <a class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y" href="">
                        <div class="zoom-in">
                            <div class="box border-3">
                                <div class="flex">
                                    {{-- <i style="width:43px; height:43px;" data-feather="user" class="report-box__icon text-theme-1 m-auto"></i> --}}
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-5">15</div>
                                <div class="text-3xl leading-8 mb-5">Active Jobs</div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y" href="jobs/new_job">
                        <div class="zoom-in">
                            <div class="box border-3">
                                <div class="flex">
                                    {{-- <i style="width:43px; height:43px;" data-feather="layers" class="report-box__icon text-theme-1 m-auto"></i> --}}

                                </div>
                                <div class="text-3xl eading-8 mt-10 mb-10">Create Job</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="intro-y flex items-center h-8 mt-6 mb-6 xl:ml-12 xl:mr-12" style="background-color: #edeef0">
                    <h5 style="font-size: 0.975rem; font-weight: bold;" class="ml-3">Active Jobs</h5>
                </div>
                <div class="grid grid-cols-12 gap-6 xl:col-span-2 intro-y xl:ml-12 xl:mr-12">
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="">
                        <div class="zoom-in">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0;" >
                                <div class="flex" style="background-color: black; min-height: 30px">
                                </div>
                                <div class="m-2">
                                <div><b>Client:</b> Mr Scaffold</div>
                                <div><b>Location:</b> 254 canterbarry Road, Belmore NSW 2192</div>
                                <div><b>Active Workers:</b> 15</div>
                                </div>
                                <div class="flex mt-2 mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div class="flex ml-2">
                                    <b>#2445</b>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="">
                        <div class="zoom-in">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0;" >
                                <div class="flex" style="background-color: black; min-height: 30px">
                                </div>
                                <div class="m-2">
                                <div><b>Client:</b> Mr Scaffold</div>
                                <div><b>Location:</b> 254 canterbarry Road, Belmore NSW 2192</div>
                                <div><b>Active Workers:</b> 15</div>
                                </div>
                                <div class="flex mt-2 mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div class="flex ml-2">
                                    <b>#2445</b>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="">
                        <div class="zoom-in">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0;" >
                                <div class="flex" style="background-color: black; min-height: 30px">
                                </div>
                                <div class="m-2">
                                <div><b>Client:</b> Mr Scaffold</div>
                                <div><b>Location:</b> 254 canterbarry Road, Belmore NSW 2192</div>
                                <div><b>Active Workers:</b> 15</div>
                                </div>
                                <div class="flex mt-2 mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div class="flex ml-2">
                                    <b>#2445</b>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="">
                        <div class="zoom-in">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0;" >
                                <div class="flex" style="background-color: black; min-height: 30px">
                                </div>
                                <div class="m-2">
                                <div><b>Client:</b> Mr Scaffold</div>
                                <div><b>Location:</b> 254 canterbarry Road, Belmore NSW 2192</div>
                                <div><b>Active Workers:</b> 15</div>
                                </div>
                                <div class="flex mt-2 mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div class="flex ml-2">
                                    <b>#2445</b>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="">
                        <div class="zoom-in">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0;" >
                                <div class="flex" style="background-color: black; min-height: 30px">
                                </div>
                                <div class="m-2">
                                <div><b>Client:</b> Mr Scaffold</div>
                                <div><b>Location:</b> 254 canterbarry Road, Belmore NSW 2192</div>
                                <div><b>Active Workers:</b> 15</div>
                                </div>
                                <div class="flex mt-2 mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div class="flex ml-2">
                                    <b>#2445</b>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="">
                        <div class="zoom-in">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0;" >
                                <div class="flex" style="background-color: black; min-height: 30px">
                                </div>
                                <div class="m-2">
                                <div><b>Client:</b> Mr Scaffold</div>
                                <div><b>Location:</b> 254 canterbarry Road, Belmore NSW 2192</div>
                                <div><b>Active Workers:</b> 15</div>
                                </div>
                                <div class="flex mt-2 mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div class="flex ml-2">
                                    <b>#2445</b>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="">
                        <div class="zoom-in">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0;" >
                                <div class="flex" style="background-color: black; min-height: 30px">
                                </div>
                                <div class="m-2">
                                <div><b>Client:</b> Mr Scaffold</div>
                                <div><b>Location:</b> 254 canterbarry Road, Belmore NSW 2192</div>
                                <div><b>Active Workers:</b> 15</div>
                                </div>
                                <div class="flex mt-2 mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div class="flex ml-2">
                                    <b>#2445</b>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="">
                        <div class="zoom-in">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0;" >
                                <div class="flex" style="background-color: black; min-height: 30px">
                                </div>
                                <div class="m-2">
                                <div><b>Client:</b> Mr Scaffold</div>
                                <div><b>Location:</b> 254 canterbarry Road, Belmore NSW 2192</div>
                                <div><b>Active Workers:</b> 15</div>
                                </div>
                                <div class="flex mt-2 mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div class="flex ml-2">
                                    <b>#2445</b>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>


@endsection()
