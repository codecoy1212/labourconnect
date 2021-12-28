@extends('scripts')

@section('up_title', 'Roles')
@section('first_ref', 'Roles')
@section('pg_act', 'breadcrumb--active')
@section('pg_act_ro', 'side-menu--active')

<?php $add = route('oles');?>
@section('first_add',$add)

@section('main_content')

<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
        <!-- BEGIN: General Report -->
        <div class="col-span-12 mt-4">
            <div class="intro-y flex items-center h-8 xl:ml-12 xl:mr-12 mb-8" style="background-color: #edeef0">
                <h5 style="font-size: 0.975rem; font-weight: bold;" class="ml-3">Roles</h5>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">
                <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y mb-2">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="box border-3" style="text-align: center; line-height: 2.0; height: 180px;">
                                <div class="" style="height: 40px;">
                                    <div class="ml-2">Add New Role </div>
                                </div>
                                <div class="flex mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mt-6 mb-2 ml-10">
                                    <form id="add_role_form" class="my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="" method="post">
                                    @csrf
                                        <input type="text" name="role_name" id="add_role_id" class="p-2 border-theme-123 border-2 block mb-2" style="width: 82%; height:30px; font-size:85%;" placeholder="Role Name">
                                        <div class="intro-x mt-2 mr-12" style="text-align: left">
                                            <button class="text-white bg-theme-123 p-0 pl-2 pr-2 btn_zoo_h" style="font-size: 85%;">Add Role</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y mb-2">
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mb-2">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="box border-3" style=" line-height: 2.0; height: 336px;">
                                <div class="" style="height: 40px; text-align: center;">
                                    <div class="ml-2">Current Roles</div>
                                </div>
                                <div class="flex mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <form id="search_form" class="my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="" method="get">
                                    @csrf
                                    <div  class="flex" style="">
                                    <input type="text" name="search" id="search_id" class="p-2 border-theme-123 border-2 block m-2" style="height:35px; width: 81%; font-size:85%; display:inline" placeholder="Search Role...">
                                    <div class="" style="">
                                        <button class="text-white bg-theme-123 m-2 ml-0 p-0 pl-2 pr-2 btn_zoo_h" style="font-size: 85%;">Search</button>
                                    </div>
                                    <div id="">
                                        <button value="" class="cancel_search text-white bg-theme-123 m-2 ml-0 p-0 pl-2 pr-2 btn_zoo_h" style="font-size: 85%;">X</button>
                                    </div>
                                    </div>
                                </form>
                                <div class="flex mb-0" style="min-height: 2px; background-color:black;">
                                </div>
                                <div id="check2" ></div>
                            </div>
                            <div id="check" ></div>
                        </div>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6 xl:col-span-2 intro-y xl:ml-12 xl:mr-12">
            </div>
        </div>
    </div>
</div>

<div class="modal" id="edit_role_modal" style="">
    <div class="modal__content">
        <div class="px-5 pb-0"><br>
            <div style="font-size:25px">Edit Role</div>
        </div>
        <form id="edit_role_form">
            @csrf
            <input type="hidden" id="update_val_id" name="id">
            <div class="intro-y col-span-12 lg:col-span-8 p-5">
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-12 px-2">
                        <div class="mb-2">Role Name</div>
                        <input type="text" name="role_name" id="edit_role_id" class="input w-full border flex-1">
                    </div>
                </div><br>
            </div>
            <div class="px-5 pb-8 text-right">
                <button type="button" data-dismiss="modal" class="p-2 w-24 border text-gray-700 mr-1">Close</button>
                <button type="submit" id="edit_school_done" class="p-2 w-24 bg-theme-123 btn_zoo_h text-white">Update</button>
            </div>
        </form>
    </div>
</div>

<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>

<script>

    $(document).ready(function(){

        var glb_vbl = "";

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $(document).on("submit","#search_form", function(event){
            event.preventDefault();
            $("#check2").empty();
            $("#check").empty();
            glb_vbl = $("#search_id").val();
            // console.log(glb_vbl);
            $.ajax({
                type:"GET",
                url:"roles/search",
                data: $("#search_form").serialize(),
                success: function(data){
                    console.log(data);
                    // toastr.success("Role Added");
                    $("#add_role_id").val("");
                    // new_fun(1);

                    var vbl1 = data.links.length-2;
                    var vbl2 = data.current_page+1;

                    // var my_array = data;
                    // var json = JSON.stringify( my_array );

                    // console.log(my_array);

                    for (let i = 0; i < data.data.length; i++) {
                        $("#check2").append(`
                            <div  class="flex border-2 border-theme-123 m-2 btn_zoo_g " style="height: 30px;font-size:0.9rem; ">
                                <button value="`+data.data[i].id+`" class="ml-2 mr-auto update_role" id="special_id" style="display:inline">`+data.data[i].r_name+`</button>
                                <button value="`+data.data[i].id+`" class="mr-2 delete_role"> x </button>
                            </div>
                        `);
                    }

                    var trs = `<div class="mt-2" style="height: 30px;font-size:0.9rem; ">
                                <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700 leading-5">
                                            Showing
                                            <span class="font-medium">`+data.current_page+`</span>
                                                of
                                            <span class="font-medium">`+vbl1+`</span>
                                            pages.
                                        </p>
                                    </div>
                                    <div>`;

                    if(data.current_page == 1 && data.current_page == data.links.length-2)
                    {
                        trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                            « Previous
                                        </span>
                                    </span>
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                            Next »
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </nav>
                    </div>`;
                    }

                    if(data.current_page == 1 && data.current_page < data.links.length-2 )
                    {
                        trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                            « Previous
                                        </span>
                                    </span>
                                    <button value="`+vbl2+`" class="next_pg_search relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                        Next »
                                    </button>
                                </span>
                            </div>
                        </nav>
                    </div>`;
                    }

                    $("#check").append(trs);

                },
                error: function(error){
                    // alert("School Not Added.");
                    // $.each(error.responseJSON,function(key,value) {
                    // toastr.error(value[0]);
                    // // $("#add_subject_errors").append(`<li>`+value[0]+`</li>`);
                    // });
                    // console.log(error);
                }
            });
        });

        $(document).on("click",".cancel_search",function(e){
            e.preventDefault();
            $("#check2").empty();
            $("#check").empty();
            $("#search_id").val("");
            new_fun(1);

        });

        $(document).on("submit","#add_role_form", function(event){
            event.preventDefault();
            $.ajax({
                type:"POST",
                url:"roles/add",
                data: $("#add_role_form").serialize(),
                success: function(response){
                    console.log(response);
                    toastr.success("Role Added");
                    $("#add_role_id").val("");
                    new_fun(1);
                    // location.reload();
                    // alert("School Added.");
                    // var table = $("#schools_table").DataTable();
                    // table.ajax.reload();
                },
                error: function(error){
                    // alert("School Not Added.");
                    $.each(error.responseJSON,function(key,value) {
                    toastr.error(value[0]);
                    // $("#add_subject_errors").append(`<li>`+value[0]+`</li>`);
                    });
                    // console.log(error);
                }
            });
        });

        get_fun();
        function get_fun(){
            $.ajax({
                type:"GET",
                url:'roles/show',
            }).done(function(data){
            // console.log(data);

            var vbl1 = data.links.length-2;
            var vbl2 = data.current_page+1;

            // var my_array = data;
            // var json = JSON.stringify( my_array );

            // console.log(my_array);

            for (let i = 0; i < data.data.length; i++) {
                $("#check2").append(`
                    <div  class="flex border-2 border-theme-123 m-2 btn_zoo_g " style="height: 30px;font-size:0.9rem; ">
                        <button value="`+data.data[i].id+`" class="ml-2 mr-auto update_role" id="special_id" style="display:inline">`+data.data[i].r_name+`</button>
                        <button value="`+data.data[i].id+`" class="mr-2 delete_role"> x </button>
                    </div>
                `);
            }

            var trs = `<div class="mt-2" style="height: 30px;font-size:0.9rem; ">
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-700 leading-5">
                                    Showing
                                    <span class="font-medium">`+data.current_page+`</span>
                                        of
                                    <span class="font-medium">`+vbl1+`</span>
                                    pages.
                                </p>
                            </div>
                            <div>`;

            if(data.current_page == 1 && data.current_page == data.links.length-2)
            {
                trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    « Previous
                                </span>
                            </span>
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    Next »
                                </span>
                            </span>
                        </span>
                    </div>
                </nav>
            </div>`;
            }

            if(data.current_page == 1 && data.current_page < data.links.length-2 )
            {
                trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    « Previous
                                </span>
                            </span>
                            <button value="`+vbl2+`" class="next_pg relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                Next »
                            </button>
                        </span>
                    </div>
                </nav>
            </div>`;
            }

            $("#check").append(trs);

            });
        }

        $(document).on("click",".next_pg",function(e){
            e.preventDefault();
            var id2 = $(this).val();
            // console.log(id2);
            new_fun(id2);
        });

        $(document).on("click",".next_pg_search",function(e){
            e.preventDefault();
            var id2 = $(this).val();
            // console.log(id2);
            new_fun_2(id2);
        });

        function new_fun_2(id2){
            $("#check2").empty();
            $("#check").empty();
            $.ajax({
                type:"GET",
                url:'roles/search?search='+glb_vbl+'&page='+id2+'',
            }).done(function(data){

            var vbl1 = data.links.length-2;

            var vbl2 = data.current_page+1;

            var vbl3 = data.current_page-1;

            for (let i = 0; i < data.data.length; i++)
            {
                $("#check2").append(`
                    <div  class="flex border-2 border-theme-123 m-2 btn_zoo_g " style="height: 30px;font-size:0.9rem; ">
                        <button value="`+data.data[i].id+`"  class="ml-2 mr-auto update_role" id="special_id" style="display:inline">`+data.data[i].r_name+`</button>
                        <button value="`+data.data[i].id+`" class="mr-2 delete_role"> x </button>
                    </div>
                `);
            }

            var trs = `<div class="mt-2" style="height: 30px;font-size:0.9rem; ">
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-700 leading-5">
                                    Showing
                                    <span class="font-medium">`+data.current_page+`</span>
                                        of
                                    <span class="font-medium">`+vbl1+`</span>
                                    pages.
                                </p>
                            </div>
                            <div>`;

            if(data.current_page == 1 && data.current_page == data.links.length-2)
            {
                trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    « Previous
                                </span>
                            </span>
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    Next »
                                </span>
                            </span>
                        </span>
                    </div>
                </nav>
            </div>`;
            }

            if(data.current_page == 1 && data.current_page < data.links.length-2 )
            {
                trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    « Previous
                                </span>
                            </span>
                            <button value="`+vbl2+`" class="next_pg_search relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                Next »
                            </button>
                        </span>
                    </div>
                </nav>
            </div>`;
            }

            if(data.current_page > 1 &&  data.current_page < data.links.length-2 )
            {
                trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <button value="`+vbl3+`" class="next_pg_search relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                « Previous
                            </button>
                            <button value="`+vbl2+`" class="next_pg_search relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                Next »
                            </button>
                        </span>
                    </div>
                </nav>
            </div>`;
            }

            if(data.current_page > 1 &&  data.current_page == data.links.length-2 )
            {
                trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <button value="`+vbl3+`" class="next_pg_search relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                « Previous
                            </button>
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    Next »
                                </span>
                            </span>
                        </span>
                    </div>
                </nav>
            </div>`;
            }

            $("#check").append(trs);

            });
        }

        function new_fun(id2){
            $("#check2").empty();
            $("#check").empty();
            $("#update_subject_errors").empty();
            $.ajax({
                type:"GET",
                url:'roles/show?page='+id2+'',
            }).done(function(data){
            // console.log(data);

            var vbl1 = data.links.length-2;

            var vbl2 = data.current_page+1;

            var vbl3 = data.current_page-1;

            for (let i = 0; i < data.data.length; i++)
            {
                $("#check2").append(`
                    <div  class="flex border-2 border-theme-123 m-2 btn_zoo_g " style="height: 30px;font-size:0.9rem; ">
                        <button value="`+data.data[i].id+`"  class="ml-2 mr-auto update_role" id="special_id" style="display:inline">`+data.data[i].r_name+`</button>
                        <button value="`+data.data[i].id+`" class="mr-2 delete_role"> x </button>
                    </div>
                `);
            }

            var trs = `<div class="mt-2" style="height: 30px;font-size:0.9rem; ">
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-700 leading-5">
                                    Showing
                                    <span class="font-medium">`+data.current_page+`</span>
                                        of
                                    <span class="font-medium">`+vbl1+`</span>
                                    pages.
                                </p>
                            </div>
                            <div>`;

            if(data.current_page == 1 && data.current_page == data.links.length-2)
            {
                trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    « Previous
                                </span>
                            </span>
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    Next »
                                </span>
                            </span>
                        </span>
                    </div>
                </nav>
            </div>`;
            }

            if(data.current_page == 1 && data.current_page < data.links.length-2 )
            {
                trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    « Previous
                                </span>
                            </span>
                            <button value="`+vbl2+`" class="next_pg relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                Next »
                            </button>
                        </span>
                    </div>
                </nav>
            </div>`;
            }

            if(data.current_page > 1 &&  data.current_page < data.links.length-2 )
            {
                trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <button value="`+vbl3+`" class="next_pg relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                « Previous
                            </button>
                            <button value="`+vbl2+`" class="next_pg relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                Next »
                            </button>
                        </span>
                    </div>
                </nav>
            </div>`;
            }

            if(data.current_page > 1 &&  data.current_page == data.links.length-2 )
            {
                trs += `<span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <button value="`+vbl3+`" class="next_pg relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                « Previous
                            </button>
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    Next »
                                </span>
                            </span>
                        </span>
                    </div>
                </nav>
            </div>`;
            }

            $("#check").append(trs);
            });
        }

        $(document).on("click",".update_role",function(e){
            e.preventDefault();
            var id2 = $(this).val();
            // console.log(id2);
            $.ajax({
                type:"GET",
                url:'roles/show/specific/',
                data: { id: id2,},
            }).done(function(data){
            // console.log(data);
            $("#edit_role_id").val(data.r_name);
            $("#update_val_id").val(id2);
            $("#edit_role_modal").modal("show");
            });
        });

        $(document).on("submit", "#edit_role_form", function(e){
            e.preventDefault();
            $("#edit_school_errors").empty();
            var id = $("#edit_school_done").val();
            // console.log(id);

            $.ajax({
                type: 'PUT',
                url: 'roles/edit',
                data: $('#edit_role_form').serialize(),
            success: function (response){
                // console.log(response);
                $('#edit_role_modal').modal('hide');
                toastr.success("Role Updated");
                new_fun(1);
                // alert("Subject Updated.");
            },
            error: function (error){
                // console.log(error);
                $.each(error.responseJSON,function(key,value) {
                toastr.error(value[0]);
                // $("#update_subject_errors").append(`<li>`+value[0]+`</li>`);
                });
                // alert("Subject Not Updated.");
            }
            });
        });

        $(document).on("click", ".delete_role", function(e){
        var id2 = $(this).val();
        //   console.log(id2);
        if(confirm("Do you want to delete this Role ?")){
        $.ajax({
            type: 'DELETE',
            url : 'roles/delete',
            data: { id: id2,},
        }).done(function(data){
            // console.log(data);
            toastr.success("Role Deleted");
            new_fun(1);
        });
        }
        });

    });

</script>


@endsection()
