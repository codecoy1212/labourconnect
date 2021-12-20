@extends('scripts')

@section('up_title', 'Reports')
@section('first_ref', 'Reports')
@section('pg_act', 'breadcrumb--active')
@section('pg_act_rp', 'side-menu--active')

<?php $add = route('orts');?>
@section('first_add',$add)

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-4">
                <div class="intro-y flex items-center h-8 xl:ml-12 xl:mr-12" style="background-color: #edeef0">
                    <h5 style="font-size: 0.975rem; font-weight: bold;" class="ml-3">Reports</h5>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">

                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y mt-8 mb-2">

                        <div class="mb-3">Report 1</div>
                        <form class="my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="" method="post">
                            <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 85%; height:30px; font-size:85%;" placeholder="Dates:">
                            <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 85%; height:30px; font-size:85%;" placeholder="Config 1:">
                            <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 85%; height:30px; font-size:85%;" placeholder="Config 2:">
                            <div class="intro-x mt-5 xl:mt-2 xl:text-left mb-2">
                                <button class="text-white bg-theme-123 p-1 pl-2 pr-2" style="font-size: 85%; width: 85%; ">Generate Report</button>
                            </div>
                            <div class="intro-x mt-5 xl:mt-2 xl:text-left mb-2">
                                <button class="text-white bg-theme-123 p-1 pl-2 pr-2" style="font-size: 85%;">Export Report</button>
                            </div>
                            <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 85%; height:30px; font-size:85%;" placeholder="Email:">
                            <div class="intro-x mt-5 xl:mt-2 xl:text-left mb-2">
                                <button class="text-white bg-theme-123 p-1 pl-2 pr-2" style="font-size: 85%; ">Export Report</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y mt-8 mb-2">
                        <div class="mb-3">Report 2</div>
                        <form class="my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="" method="post">
                            <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 85%; height:30px; font-size:85%;" placeholder="Dates:">
                            <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 85%; height:30px; font-size:85%;" placeholder="Config 1:">
                            <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 85%; height:30px; font-size:85%;" placeholder="Config 2:">
                            <div class="intro-x mt-5 xl:mt-2 xl:text-left mb-2">
                                <button class="text-white bg-theme-123 p-1 pl-2 pr-2" style="font-size: 85%; width: 85%;">Generate Report</button>
                            </div>
                            <div class="intro-x mt-5 xl:mt-2 xl:text-left  mb-2">
                                <button class="text-white bg-theme-123 p-1 pl-2 pr-2" style="font-size: 85%; ">Export Report</button>
                            </div>
                            <input type="text" name="username" class="p-2 border-theme-123 border-2 block mb-2" style="width: 85%; height:30px; font-size:85%;" placeholder="Email:">
                            <div class="intro-x mt-5 xl:mt-2 xl:text-left  mb-2">
                                <button class="text-white bg-theme-123 p-1 pl-2 pr-2" style="font-size: 85%; ">Export Report</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 xl:col-span-2 intro-y xl:ml-12 xl:mr-12">

                </div>
            </div>
        </div>
    </div>


@endsection()
