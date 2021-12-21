@extends('scripts')

@section('up_title', 'Companies')
@section('first_ref', 'Companies')
@section('pg_act', 'breadcrumb--active')
@section('pg_act_co', 'side-menu--active')

<?php $add = route('cies');?>
@section('first_add',$add)

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-4">
                <div class="intro-y flex items-center h-8 xl:ml-12 xl:mr-12 mb-8" style="background-color: #edeef0">
                    <h5 style="font-size: 0.975rem; font-weight: bold;" class="ml-3">Companies</h5>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-5 intro-y mb-2">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="box border-3" style="text-align: center; line-height: 2.0; height: 250px;">
                                <div class="" style="height: 40px;">
                                    <div class="ml-2">Add New Company </div>
                                </div>
                                <div class="flex mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mt-6 mb-2 ml-10">
                                    <form class="my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="" method="post">
                                        <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 86%; height:30px; font-size:85%;" placeholder="Company Name">
                                        <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 86%; height:30px; font-size:85%;" placeholder="Contact Name">
                                        <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 86%; height:30px; font-size:85%;" placeholder="Phone Number">
                                        <div class="intro-x mt-2 mr-12" style="text-align:left">
                                            <button class="text-white bg-theme-123 p-0 pl-2 pr-2 btn_zoo_h" style="font-size: 85%; ">Add Company</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-1 intro-y mb-2">

                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mb-2">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="box border-3" style=" line-height: 2.0; height: 360px;">
                                    <div class="" style="height: 40px; text-align: center;">
                                        <div class="ml-2">Companies List</div>
                                    </div>
                                    <div class="flex mb-0" style="min-height: 2px; background-color:black;">
                                    </div>
                                    <div class="" style="height: 30px; font-size:0.9rem; color:black;">
                                        <div class="ml-2">Search Companies:</div>
                                    </div>
                                    <div class="flex mb-0" style="min-height: 2px; background-color:black;">
                                    </div>
                                    <a  class="flex border-2 border-theme-123 m-2 btn_zoo_g" style="height: 30px;font-size:0.9rem;" href="">
                                        <div class="ml-2 mr-auto" style="display:inline">Mr Scaffold</div>
                                        <div class="mr-2"> x </div>
                                    </a>
                                    <a  class="flex border-2 border-theme-123 m-2 btn_zoo_g" style="height: 30px;font-size:0.9rem;" href="">
                                        <div class="ml-2 mr-auto" style="display:inline">Inc Digital</div>
                                        <div class="mr-2"> x </div>
                                    </a>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 xl:col-span-2 intro-y xl:ml-12 xl:mr-12">

                </div>
            </div>
        </div>
    </div>


@endsection()
