@extends('scripts')

@section('up_title', 'New Jobs')
@section('first_ref', 'Jobs')
@section('second_ref', 'New Job')
@section('pg_act_2', 'breadcrumb--active')
@section('pg_act_jo', 'side-menu--active')

<?php $add = route('jobs');?>
@section('first_add',$add)

<?php $add2 = route('njob');?>
@section('second_add',$add2)

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-4">
                <div class="intro-y flex items-center h-8 xl:ml-12 xl:mr-12" style="background-color: #edeef0">
                    <h5 style="font-size: 0.975rem; font-weight: bold;" class="ml-3">Create New Job</h5>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mt-2">
                        Job Number: # 4453
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mt-8 mb-2">
                        <form class="my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="" method="post">
                            <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 70%; height:30px; font-size:85%;" placeholder="Search User">
                                <select id="cars" name="carlist" form="carform" class="intro-x input--lg border-theme-123 border-2 block" style="width: 70%; font-size:85%; height:30px; background-color:white;">
                                    <option value="volvo">User Role</option>
                                    <option value="saab">Saab</option>
                                    <option value="opel">Opel</option>
                                    <option value="audi">Audi</option>
                                </select>
                            <div class="intro-x mt-5 xl:mt-2 xl:text-left">
                                <button class="text-white bg-theme-123 p-1 pl-2 pr-2 btn_zoo_h" style="font-size: 85%;">Add Worker</button>
                            </div>
                        </form>
                        <form class="mt-6 my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="" method="post">
                            <select id="cars" name="carlist" form="carform" class="intro-x input--lg border-theme-123 border-2 block mb-2" style="width: 70%; font-size:85%; height:30px; background-color:white;">
                                <option value="volvo">Company Name</option>
                                <option value="saab">Saab</option>
                                <option value="opel">Opel</option>
                                <option value="audi">Audi</option>
                            </select>
                            <input type="text" name="username" class="p-2 border-theme-123 border-2 block" style="width: 70%; height:30px; font-size:85%;" placeholder="Job Location">
                            <div class="intro-x mt-5 xl:mt-2 xl:text-left">
                                <button class="text-white bg-theme-123 p-1 pl-2 pr-2 btn_zoo_h" style="font-size: 85%;">Save Job</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mb-2">
                        <div class="text-center">All Allocated Workers</div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0; height: 350px;">

                                    <a class="flex border-2 border-theme-123 m-2 btn_zoo_g" style="height: 30px;" href="">
                                        <div class="ml-2 mr-auto" style="display:inline">Waqas | Web Developer </div>
                                        <div class="mr-2"> x </div>
                                    </a>
                                    <a class="flex border-2 border-theme-123 m-2 btn_zoo_g" style="height: 30px;" href="">
                                        <div class="ml-2 mr-auto" style="display:inline">Waqas | Web Developer </div>
                                        <div class="mr-2"> x </div>
                                    </a>
                                    <a class="flex border-2 border-theme-123 m-2 btn_zoo_g" style="height: 30px;" href="">
                                        <div class="ml-2 mr-auto" style="display:inline">Waqas | Web Developer </div>
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
