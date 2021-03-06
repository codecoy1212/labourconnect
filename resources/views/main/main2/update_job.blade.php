@extends('scripts')

@section('up_title', 'Update Job')
@section('first_ref', 'Jobs')
@section('second_ref', 'Update Job')
@section('pg_act_2', 'breadcrumb--active')
@section('pg_act_jo', 'side-menu--active')

<?php $add = route('jobs');?>
@section('first_add',$add)

<?php $add2 = route('ujob',['id' => $vbl9->id]);?>
@section('second_add',$add2)

<head>
    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        td, th {
          border: 1px solid black;
          text-align: left;
          padding: 6px;
        }

    </style>
</head>

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-4">
                <div class="intro-y flex items-center h-8 xl:ml-12 xl:mr-12" style="background-color: #edeef0">
                    <h5 style="font-size: 0.975rem; font-weight: bold;" class="ml-3">Update Job</h5>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y mt-2 mb-2">
                        Job Number: {{$vbl9->id}}
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div>Add Worker</div>
                        <form id="search_form" class="my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="" method="get">
                            <div  class="flex" style="">
                                <input type="text" name="search" id="search_id" class="p-2 border-theme-123 border-2 block mr-2" style="height:34px; width: 57.2%; font-size:85%; display:inline" placeholder="Search...">
                                <div class="mb-2" style="">
                                    <button class="text-white bg-theme-123 p-2 pt-1 pb-1 btn_zoo_h" style="font-size: 85%;">Search</button>
                                </div>
                                <div id="">
                                    <button value="" class="cancel_search text-white bg-theme-123 ml-2 p-2 pt-1 pb-1 btn_zoo_h" style="font-size: 85%;">X</button>
                                </div>
                            </div>
                        </form>
                            <div id="check2"></div>
                            <div id="check"></div>
                                <select id="edit_user_role_id" name="role_id" form="update_job_form" class="select_role intro-x input--lg border-theme-123 border-2 block mb-2" style="width: 100%; font-size:85%; height:33px; background-color:white;" disabled>
                                    <option value="jfiuh4893hfubjehgw3d3" class="">Select User Role</option>
                                    @foreach ($vbl3 as $item)
                                    <option value="{{$item->id}}" class="">{{$item->r_name}}</option>
                                    @endforeach
                                </select>
                        <form id="update_job_form" class="my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="#">
                            <div class="mb-1">Select Company / Allocate Job Location</div>
                            <select id="edit_job_company_id" name="company_id" form="update_job_form" class="intro-x input--lg border-theme-123 border-2 block mb-2" style="width: 100%; font-size:85%; height:30px; background-color:white;">
                                @foreach ($vbl as $item)
                                <option value="{{$item->id}}">{{$item->c_name}}</option>
                                @endforeach
                            </select>
                            <input type="text" id="edit_job_location_id" name="j_location" form="update_job_form" class="p-2 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%;" placeholder="Job Location">
                            <div class="mb-1 mt-2">Select Job Start Date</div>
                            <input type="date" id="edit_job_date_id" name="j_date" form="update_job_form" class="border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%;" placeholder="Job Date">

                            {{-- <div class="mt-3">
                                Allocate Penality Rates
                            </div> --}}

                            {{-- <div id="" value=""class="flex border-2 border-theme-123 mt-3" style="padding-top:4px; padding-left:5px; height: 35px; width:70%; font-size:0.9rem;">
                                5 PM - 7 AM
                            </div> --}}

                            {{-- <div class="mt-3">
                                Client Charge Rate
                            </div>
                            <div>
                               <input type="number" id="charge_rate_id" name="j_charge_rate" form="update_job_form" class="border-theme-123 border-2 block p-2 mb-2" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Charge Rate">
                            </div>
                            <div class="mt-3">
                                Client Charge Rate (OT)
                            </div>
                            <div>
                               <input type="number" id="charge_rate_ot_id" name="j_charge_rate_ot" form="update_job_form" class="border-theme-123 border-2 block p-2 mb-2" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Charge Rate Overtime">
                            </div> --}}

                            {{-- <div style="font-size:15px">
                                <div>
                                    <div style="display: inline">5 PM to 7 AM</div>
                                    <input type="number" id="penality_rate_id" name="p_rate" form="new_job_form" class="border-theme-123 border-2 block p-2 mb-2" style="width: 46%; height:30px; font-size:85%; display:inline; margin-left:21px; color: red" placeholder="Penality Rate">
                                </div>
                                <div>
                                     <div style="display: inline">Saturday</div>
                                    <input type="number" id="penality_sat_rate_id" name="sat_rate" form="new_job_form" class="border-theme-123 border-2 block p-2 mb-2" style="width: 46%; height:30px; font-size:85%; display:inline; margin-left:48px; color: red" placeholder="Sat Penality">
                                </div>
                                <div>
                                    <div style="display: inline">Sunday </div>
                                    <input type="number" id="penality_sun_rate_id" name="sun_rate" form="new_job_form" class="border-theme-123 border-2 block p-2 mb-2" style="width: 46%; height:30px; font-size:85%; display:inline; margin-left:58px; color: red" placeholder="Sun Penality">
                                </div>
                            </div> --}}

                            <div class="intro-x mt-5 xl:mt-2 xl:text-left">
                                <button class="text-white bg-theme-123 p-1 pl-2 pr-2 btn_zoo_h" form="update_job_form" style="font-size: 85%;">Update Job</button>
                            </div>

                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-9 intro-y">
                        <div class="text-center">All Allocated Workers</div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0; height: 350px;">
                                <div style="width: 100%; height: 346px; overflow: auto;" class="p-1">
                                    <div id="check3" ></div>
                                    <table id="workers_table">
                                        <tr>
                                          <th>Worker Name</th>
                                          <th>Worker Role</th>
                                          <th>Worker Rate</th>
                                          <th>5PM TO 7AM (OT)</th>
                                          <th>Saturday (OT)</th>
                                          <th>Sunday (OT)</th>
                                          <th>Actions</th>
                                        </tr>
                                    </table>
                                        {{-- <tr>
                                          <td>Usama Ashraf</td>
                                          <td>Computer Operator</td>
                                          <td> <input type="number" name="" id="add_jo_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%;" placeholder="Job Rate"> </td>
                                          <td> <input type="number" name="" id="add_pe_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%;" placeholder="Penality"> </td>
                                          <td> <input type="number" name="" id="add_sa_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%;" placeholder="Saturday"> </td>
                                          <td> <input type="number" name="" id="add_su_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%;" placeholder="Sunday"> </td>
                                        </tr> --}}
                                </div>
                            </div>
                        </div>
                        </form>
                        <button class="reset_all_data text-white bg-theme-123 p-2 pt-1 pb-1 btn_zoo_h mt-2" style="font-size: 85%;">Remove All Workers</button>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y mb-2">
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-9 intro-y mb-2">
                        <div class="text-center">Allocate Charge Rate</div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0; height: 350px;">
                                <div style="width: 100%; height: 346px; overflow: auto;" class="p-1">
                                    <div id="check3"></div>
                                    <table id="workers_roles">
                                        <tr>
                                          <th>Role</th>
                                          <th>Client Charge Rate</th>
                                          <th>5PM TO 7AM (OT)</th>
                                          <th>Saturday (OT)</th>
                                          <th>Sunday (OT)</th>
                                        </tr>
                                    </table>
                                        {{-- <tr>
                                          <td>Usama Ashraf</td>
                                          <td>Computer Operator</td>
                                          <td> <input type="number" name="" id="add_jo_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%;" placeholder="Job Rate"> </td>
                                          <td> <input type="number" name="" id="add_pe_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%;" placeholder="Penality"> </td>
                                          <td> <input type="number" name="" id="add_sa_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%;" placeholder="Saturday"> </td>
                                          <td> <input type="number" name="" id="add_su_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%;" placeholder="Sunday"> </td>
                                        </tr> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y mb-2">
                        <div class="text-center">Allocates Workers Rates</div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0; height: 350px;">
                                <div class="ml-2 mr-2" style="font-size:15px">
                                    <div style="display:inline">
                                        Role
                                    </div>
                                    <div style="margin-left:40%; display:inline">
                                        Enter Rate
                                    </div>
                                    <div style="height: 2px; background-color:black" class="mb-2" ></div>
                                    <div style="width: 100%; height: 295px; overflow: auto" >
                                        <form id="prices_form" action="" method="post">
                                        <div id="check4" ></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mb-2">
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 xl:col-span-2 intro-y xl:ml-12 xl:mr-12">

                </div>
            </div>
        </div>
    </div>


<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>

<script>

    $(document).ready(function(){

        var glb_vbl = "";
        var glb_arr = [];           //job_users
        var glb_arr_2 = [];         //user_roles
        var glb_arr_4 = [];         //job_rates
        var glb_arr_5 = [];         //p_rates
        var glb_arr_6 = [];         //sat_rates
        var glb_arr_7 = [];         //sun_rate

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });


        var get_data = "<?php echo $vbl9->id; ?>";
        // console.log(get_data);

        $.ajax({
            type:"GET",
            url:'specific/detail',
            data: {id: get_data},
            success: function(data){
                console.log(data);

                $("#edit_job_location_id").val(data[0].j_location);
                $("#edit_job_company_id").val(data[0].company_id);
                $("#edit_job_date_id").val(data[0].j_date);
                // $("#charge_rate_id").val(data[0].charge_rate);
                // $("#charge_rate_ot_id").val(data[0].charge_rate_ot);
                // $("#penality_rate_id").val(data[0].p_rate);
                // $("#penality_sat_rate_id").val(data[0].sat_rate);
                // $("#penality_sun_rate_id").val(data[0].sun_rate);

                for (let i = 0; i < data[1].length; i++) {

                    glb_arr.push(data[1][i].id);
                    glb_arr_2.push(data[1][i].role_id);
                    // console.log(glb_arr);

                    // $("#check3").append(`
                    // <button id="edit_job_user_btn`+data[1][i].id+`" value="`+data[1][i].id+`&`+data[1][i].role_id+`"class="remove_btn flex border-2 border-theme-123 btn_zoo_g m-2" style="height: 30px; width:97.5%; font-size:0.9rem;">
                    // <input type="hidden" id="edit_job_user_id`+data[1][i].id+`" form="update_job_form" value="`+data[1][i].id+`" name="id`+data[1][i].id+`">
                    // <div class="mr-auto ml-2">
                    //     `+data[1][i].u_name+` | `+data[1][i].r_name+`
                    // </div>
                    // <div class="mr-2"><b> x </b></div>
                    // </button>
                    // `);

                    $('#workers_table tr:last').after(`
                    <tr id="edit_job_user_id`+data[1][i].id+`">
                        <td>`+data[1][i].u_name+`</td>
                        <td>`+data[1][i].r_name+`</td>
                        <input type="hidden" form="update_job_form" name="user_id" value="`+data[1][i].id+`">
                        <td> <input type="number" form="update_job_form" name="jo_rate`+data[1][i].id+`" id="add_jo_rate`+data[1][i].id+`" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Job Rate" required> </td>
                        <td> <input type="number" form="update_job_form" name="pe_rate`+data[1][i].id+`" id="add_pe_rate`+data[1][i].id+`" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Penality" required> </td>
                        <td> <input type="number" form="update_job_form" name="sa_rate`+data[1][i].id+`" id="add_sa_rate`+data[1][i].id+`" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Saturday" required> </td>
                        <td> <input type="number" form="update_job_form" name="su_rate`+data[1][i].id+`" id="add_su_rate`+data[1][i].id+`" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Sunday" required> </td>
                        <td> <button value="`+data[1][i].id+`&`+data[1][i].role_id+`" class="remove_btn text-white bg-theme-6 p-2 pl-2 pr-2 btn_zoo_h"> remove </button> </td>
                    </tr>
                    `);

                    // console.log(data[1][i].job_rate);
                    // console.log(data[1][i].p_rate);
                    // console.log(data[1][i].sat_rate);
                    // console.log(data[1][i].sun_rate);

                    $('#add_jo_rate'+data[1][i].id+'').val(data[1][i].job_rate);
                    $('#add_pe_rate'+data[1][i].id+'').val(data[1][i].p_rate);
                    $('#add_sa_rate'+data[1][i].id+'').val(data[1][i].sat_rate);
                    $('#add_su_rate'+data[1][i].id+'').val(data[1][i].sun_rate);


                    if ($('#add_job_role_name'+data[1][i].role_id+'').length) {              //to check if a div exists
                        // console.log(('#add_job_user_id'+data.id+''));
                        // toastr.info("Worker Role Already Added");
                    }
                    else
                    {
                        // $("#check4").append(`
                        // <div id="add_job_role_name`+data[1][i].role_id+`" class="flex">
                        // <div class="flex" style="height: 30px; width:80%; font-size:0.9rem; display:inline"> `+data[1][i].r_name+`</div>
                        // <input type="number" name="`+data[1][i].role_id+`" id="edit_job_role_rate`+data[1][i].role_id+`" form="prices_form" class="p-2 border-theme-123 border-2 block ml-4 mb-2" style="color:red; width: 30%; height:30px; font-size:85%; display:inline" placeholder="Price" required><br>
                        // </div>
                        // `);
                        // $('#edit_job_role_rate'+data[1][i].role_id+'').val(data[1][i].job_rate);

                        $('#workers_roles tr:last').after(`
                        <tr id="add_job_role_name`+data[1][i].role_id+`">
                            <td>`+data[1][i].r_name+`</td>
                            <input type="hidden" form="update_job_form" name="role_id" value="`+data[1][i].role_id+`">
                            <td> <input type="number" form="update_job_form" name="c_jo_rate`+data[1][i].role_id+`" id="add_c_jo_rate`+data[1][i].role_id+`" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Client Charge Rate" required> </td>
                            <td> <input type="number" form="update_job_form" name="c_pe_rate`+data[1][i].role_id+`" id="add_c_pe_rate`+data[1][i].role_id+`" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="5pm to 7am OT" required> </td>
                            <td> <input type="number" form="update_job_form" name="c_sa_rate`+data[1][i].role_id+`" id="add_c_sa_rate`+data[1][i].role_id+`" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Saturday OT" required> </td>
                            <td> <input type="number" form="update_job_form" name="c_su_rate`+data[1][i].role_id+`" id="add_c_su_rate`+data[1][i].role_id+`" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Sunday OT" required> </td>
                        </tr>
                        `);

                        $('#add_c_jo_rate'+data[1][i].role_id+'').val(data[1][i].c_charge_rate);
                        $('#add_c_pe_rate'+data[1][i].role_id+'').val(data[1][i].c_p_rate);
                        $('#add_c_sa_rate'+data[1][i].role_id+'').val(data[1][i].c_sat_rate);
                        $('#add_c_su_rate'+data[1][i].role_id+'').val(data[1][i].c_sun_rate);
                    }
                }

                // console.log(glb_arr);
                // console.log(glb_arr_2);

            },
            error: function(error){
                // console.log(error);
            },
        });

        $(document).on("submit","#search_form", function(event){
            event.preventDefault();
            $("#check2").empty();
            $("#check").empty();
            glb_vbl = $("#search_id").val();
            // console.log(glb_vbl);
            $.ajax({
                type:"GET",
                url:"../search",
                data: $("#search_form").serialize(),
                success: function(data){
                    // console.log(data);
                    // toastr.success("Company Added");
                    // new_fun(1);

                    var vbl1 = data.links.length-2;
                    var vbl2 = data.current_page+1;

                    // var my_array = data;
                    // var json = JSON.stringify( my_array );

                    // console.log(my_array);

                    for (let i = 0; i < data.data.length; i++) {
                        $("#check2").append(`
                            <button value="`+data.data[i].id+`" class="allocated_add flex border-2 border-theme-123 btn_zoo_g mb-2 p-1" style="height: 30px; width:100%; font-size:0.9rem;">
                            <div class="mr-auto">
                                `+data.data[i].u_name+`
                            </div>
                            <div><b> Add </b></div>
                            </button>
                        `);
                    }

                    var trs = `<div class="mt-2 mb-4" style="height: 30px; width:100%; font-size:0.9rem; ">
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
                                            ??
                                        </span>
                                    </span>
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                            ??
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
                                            ??
                                        </span>
                                    </span>
                                    <button value="`+vbl2+`" class="next_pg_search relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                        ??
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
            $('#edit_user_role_id').prop('disabled', true);
            $('#edit_user_role_id').val("jfiuh4893hfubjehgw3d3");

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
                url:'../search?search='+glb_vbl+'&page='+id2+'',
            }).done(function(data){

            var vbl1 = data.links.length-2;

            var vbl2 = data.current_page+1;

            var vbl3 = data.current_page-1;

            for (let i = 0; i < data.data.length; i++)
            {
                $("#check2").append(`
                    <button value="`+data.data[i].id+`"class="allocated_add flex border-2 border-theme-123 btn_zoo_g mb-2 p-1" style="height: 30px; width:100%; font-size:0.9rem;">
                    <div class="mr-auto">
                        `+data.data[i].u_name+`
                    </div>
                    <div><b> Add </b></div>
                    </button>
                `);
            }

            var trs = `<div class="mt-2 mb-4" style="height:30px; width:100%; font-size:0.9rem; ">
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
                                    ??
                                </span>
                            </span>
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                    ??
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
                                    ??
                                </span>
                            </span>
                            <button value="`+vbl2+`" class="next_pg_search relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                ??
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
                                ??
                            </button>
                            <button value="`+vbl2+`" class="next_pg_search relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 2">
                                ??
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
                                ??
                            </button>
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                ??
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

        var user_id_to_add = 0;

        $(document).on("change",".select_role",function(e){
            var id2 = $(this).val();
            // console.log(id2);
            // console.log(user_id_to_add);

            $.ajax({
                type:"GET",
                url:'../../jobs/show/user/role/',
                data: { id: user_id_to_add, role_id: id2},
            }).done(function(data){
                // console.log(data)

                // console.log(glb_arr);
                glb_arr.push(data[0].id);
                var xtreme = Number(id2)
                glb_arr_2.push(xtreme);
                // console.log(glb_arr);

                // console.log(glb_arr);
                // console.log(glb_arr_2);

                // $("#check3").append(`
                // <button id="edit_job_user_btn`+data[0].id+`" value="`+data[0].id+`&`+id2+`"class="remove_btn flex border-2 border-theme-123 btn_zoo_g m-2" style="height: 30px; width:96%; font-size:0.9rem;">
                // <input type="hidden" id="edit_job_user_id`+data[0].id+`" form="update_job_form" value="`+data[0].id+`" name="id`+data[0].id+`">
                // <div class="mr-auto ml-2">
                //     `+data[0].u_name+` | `+data[1].r_name+`
                // </div>
                // <div class="mr-2"><b> x </b></div>
                // </button>
                // `);

                $('#workers_table tr:last').after(`
                    <tr id="edit_job_user_id`+data[0].id+`">
                        <td>`+data[0].u_name+`</td>
                        <td>`+data[1].r_name+`</td>
                        <input type="hidden" form="update_job_form" name="user_id" value="`+data[0].id+`">
                        <td> <input type="number" form="update_job_form" name="jo_rate`+data[0].id+`" id="add_jo_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Job Rate" required> </td>
                        <td> <input type="number" form="update_job_form" name="pe_rate`+data[0].id+`" id="add_pe_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Penality" required> </td>
                        <td> <input type="number" form="update_job_form" name="sa_rate`+data[0].id+`" id="add_sa_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Saturday" required> </td>
                        <td> <input type="number" form="update_job_form" name="su_rate`+data[0].id+`" id="add_su_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Sunday" required> </td>
                        <td> <button value="`+data[0].id+`&`+id2+`" class="remove_btn text-white bg-theme-6 p-2 pl-2 pr-2 btn_zoo_h"> remove </button> </td>
                    </tr>
                `);

                // if ($('#add_job_role_name'+data[1].id+'').length) {              //to check if a div exists
                //     // console.log(('#add_job_user_id'+data.id+''));
                //     toastr.info("Worker Role Already Added");
                // }
                // else
                // {
                //     $("#check4").append(`
                //     <div id="add_job_role_name`+data[1].id+`" class="flex">
                //     <div class="flex" style="height: 30px; width:80%; font-size:0.9rem; display:inline"> `+data[1].r_name+`</div>
                //     <input type="number" name="`+data[1].id+`" form="prices_form" class="p-2 border-theme-123 border-2 block ml-4 mb-2" style="color:red; width: 30%; height:30px; font-size:85%; display:inline" placeholder="Price" required><br>
                //     </div>
                //     `);
                // }

                if ($('#add_job_role_name'+data[1].id+'').length) {              //to check if a div exists
                    // console.log(('#add_job_user_id'+data.id+''));
                    toastr.info("Worker Role Already Added");
                }
                else
                {
                    $('#workers_roles tr:last').after(`
                    <tr id="add_job_role_name`+data[1].id+`">
                        <td>`+data[1].r_name+`</td>
                        <input type="hidden" form="update_job_form" name="role_id" value="`+data[1].id+`">
                        <td> <input type="number" form="update_job_form" name="c_jo_rate`+data[1].id+`" id="add_c_jo_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Client Charge Rate" required> </td>
                        <td> <input type="number" form="update_job_form" name="c_pe_rate`+data[1].id+`" id="add_c_pe_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="5pm to 7am OT" required> </td>
                        <td> <input type="number" form="update_job_form" name="c_sa_rate`+data[1].id+`" id="add_c_sa_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Saturday OT" required> </td>
                        <td> <input type="number" form="update_job_form" name="c_su_rate`+data[1].id+`" id="add_c_su_rate" class="p-1 border-theme-123 border-2 block" style="width: 100%; height:30px; font-size:85%; color: red" placeholder="Sunday OT" required> </td>
                    </tr>
                    `);
                }

                $('#edit_user_role_id').prop('disabled', true);
                $('#search_id').val("");
                toastr.success("User Added to Que.");
                $('#edit_user_role_id').val("jfiuh4893hfubjehgw3d3");
                // console.log(glb_arr);
                // console.log(glb_arr_2);
            });

        });

        $(document).on("click",".allocated_add",function(e){
            e.preventDefault();
            var id2 = $(this).val();
            $("#check2").empty();
            $("#check").empty();
            // console.log(id2);
            $.ajax({
                type:"GET",
                url:'../../users/show/specific/',
                data: { id: id2,},
            }).done(function(data){
            // console.log(data);
            // $("#edit_c_name_id").val(data.u_name);
            // $("#edit_c_contact_id").val(data.c_contact);
            // $("#edit_c_phone_id").val(data.c_phone);
            // $("#update_val_id").val(id2);
            // $("#edit_company_modal").modal("show");

            // console.log(('#add_job_user_id'+data.id+''));

                if ($('#edit_job_user_id'+id2+'').length) {              //to check if a div exists
                    // console.log(('#add_job_user_id'+data.id+''));
                    toastr.error("Worker Already Added");
                }
                else
                {
                    $("#search_id").val(data.u_name);
                    // console.log("");
                    toastr.info("Now Select Role for the user...");
                    $("#edit_user_role_id").removeAttr("disabled");
                    user_id_to_add = data.id;
                }
            });
        });


        $(document).on("click",".remove_btn",function(e){
            e.preventDefault();
            var id2 = $(this).val();
            // console.log(id2);
            const myArray = id2.split("&");

            // $.each(myArray,function(key,value) {
            //     console.log(value);
            // });

            // console.log(myArray[0]);
            // console.log(myArray[1]);

            if(confirm("Do you want to remove this worker ?")){
                $('#edit_job_user_id'+myArray[0]+'').remove();

                // console.log(id2);
                for (let i = 0; i < glb_arr.length; i++) {
                    if(glb_arr[i] == myArray[0])
                    {
                        glb_arr.splice(i, 1);
                        break;
                    }
                }

                for (let i = 0; i < glb_arr_2.length; i++) {
                    if(glb_arr_2[i] == myArray[1])
                    {
                        glb_arr_2.splice(i, 1);
                        break;
                    }
                }


                var checking = 0;
                for (let i = 0; i < glb_arr_2.length; i++) {
                    if(glb_arr_2[i] == myArray[1])
                    {
                        checking = 1;
                        break;
                    }
                }
                if(checking == 1){}
                else
                    $('#add_job_role_name'+myArray[1]+'').remove();

                // console.log(glb_arr);
                // console.log(glb_arr_2);
                // console.log(glb_arr);
                toastr.success("User Removed from Que.");
            }
        });

        $(document).on("submit","#update_job_form", function(event){
            event.preventDefault();
            var id1 = $("#edit_job_company_id").val();
            var id2 = $("#edit_job_location_id").val();
            var id3 = $("#edit_job_date_id").val();
            // var id4 = $("#charge_rate_id").val();
            // var id5 = $("#charge_rate_ot_id").val();
            // var id4 = $("#penality_rate_id").val();
            // var id5 = $("#penality_sat_rate_id").val();
            // var id6 = $("#penality_sun_rate_id").val();

            var str = $("#update_job_form").serializeArray();
            // console.log(str);

            // var str = $("#prices_form").serialize();
            // // console.log(str);

            // glb_arr_3 = [];
            // const myArray = str.split("&");
            // $.each(myArray,function(key,value) {
            //     // console.log(value);
            //     const myArray2 = value.split("=");
            //     $.each(myArray2,function(key2,value2) {
            //         // console.log(value2);
            //         glb_arr_3.push(value2);
            //     });
            // });
            // console.log(glb_arr_3);


            // console.log(id1,id2);
            $.ajax({
                type:"PUT",
                url:"../edit",
                // data: {job_id: get_data, j_location: id2, company_id: id1,  j_date: id3, job_users: glb_arr, users_role: glb_arr_2},
                // data: {job_id: get_data, j_location: id2, company_id: id1, j_date: id3, job_users: glb_arr, users_role: glb_arr_2, roles_prices: glb_arr_3, p_rate: id4, sat_rate: id5, sun_rate: id6},
                // data: {job_id: get_data, j_location: id2, company_id: id1, j_date: id3, charge_rate: id4, charge_rate_ot: id5, job_users: glb_arr, users_role: glb_arr_2, users_rates: str},
                data: {job_id: get_data, j_location: id2, company_id: id1, j_date: id3, job_users: glb_arr, users_role: glb_arr_2, users_rates: str},
                success: function(response){
                    // console.log(response);
                    toastr.success("Job Updated");
                    window.location.replace("../../jobs");
                },
                error: function(error){
                    // alert("School Not Added.");
                    $.each(error.responseJSON,function(key,value) {
                    toastr.error(value[0]);
                    });
                    // $("#add_subject_errors").append(`<li>`+value[0]+`</li>`);
                    // console.log(error);
                }
            });
        });

        $(document).on("click",".reset_all_data",function(e){
            // console.log("HELLO");
            if(confirm("Do you want to remove all allocated workers ?")){
                // $("#check4").empty();
                // $("#check3").empty();

                for (let i = 0; i < glb_arr.length; i++) {
                    // console.log(glb_arr[i]);
                    $('#edit_job_user_id'+glb_arr[i]+'').remove();
                }

                glb_arr = [];
                glb_arr_2 = [];

                // console.log(glb_arr);
                // console.log(glb_arr_2);

                toastr.success("All allocated workers removed.");
            }

        });

    });

</script>


@endsection()
