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

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-4">
                <div class="intro-y flex items-center h-8 xl:ml-12 xl:mr-12" style="background-color: #edeef0">
                    <h5 style="font-size: 0.975rem; font-weight: bold;" class="ml-3">Update Job</h5>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mt-2">
                        Job Number: #{{$vbl9->id}}
                        <Button class="delete_job text-white bg-theme-123 p-2 pt-1 pb-1 btn_zoo_h" style="margin-left:20px">Delete Job</Button>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mt-8 mb-2">
                        <div>Add Worker</div>
                        <form id="search_form" class="my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="" method="get">
                            <div  class="flex" style="">
                                <input type="text" name="search" id="search_id" class="p-2 border-theme-123 border-2 block mr-2" style="height:34px; width: 64.8%; font-size:85%; display:inline" placeholder="Search User...">
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
                        <form id="update_job_form" class="my-auto mx-auto bg-white xl:bg-transparent sm:px-8 xl:p-0 rounded-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto" action="" method="post">
                            <div class="mb-1">Select Company</div>
                            <select id="edit_job_company_id" name="company_id" form="update_job_form" class="intro-x input--lg border-theme-123 border-2 block mb-2" style="width: 90%; font-size:85%; height:30px; background-color:white;">
                                @foreach ($vbl10 as $item)
                                <option value="{{$item->id}}">{{$item->c_name}}</option>
                                @endforeach
                            </select>
                            <input type="text" id="edit_job_location_id" name="j_location" form="update_job_form" class="p-2 border-theme-123 border-2 block" style="width: 90%; height:30px; font-size:85%;" placeholder="Job Location">
                            <div class="intro-x mt-5 xl:mt-2 xl:text-left">
                                <button class="text-white bg-theme-123 p-1 pl-2 pr-2 btn_zoo_h" style="font-size: 85%;">Update Job</button>
                            </div>

                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mb-2">
                        <div class="text-center">All Allocated Workers</div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0; height: 350px;">
                                <div id="check3" style="width: 100%; height: 346px; overflow: auto;"></div>
                            </div>
                        </div>
                        </form>
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

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        var glb_vbl = "";
        var glb_arr = [];

        var get_data = "<?php echo $vbl9->id; ?>";
        // console.log(get_data);

        $.ajax({
            type:"GET",
            url:'specific/detail',
            data: {id: get_data},
            success: function(data){
                // console.log(data);

                $("#edit_job_location_id").val(data[0].j_location);
                $("#edit_job_company_id").val(data[0].company_id);

                for (let i = 0; i < data[1].length; i++) {

                    glb_arr.push(data[1][i].id);
                    // console.log(glb_arr);

                    $("#check3").append(`
                    <button id="edit_job_user_btn`+data[1][i].id+`" value="`+data[1][i].id+`"class="remove_btn flex border-2 border-theme-123 btn_zoo_g m-2" style="height: 30px; width:96%; font-size:0.9rem;">
                    <input type="hidden" id="edit_job_user_id`+data[1][i].id+`" form="update_job_form" value="`+data[1][i].id+`" name="id`+data[1][i].id+`">
                    <div class="mr-auto ml-2">
                        `+data[1][i].u_name+`
                    </div>
                    <div class="mr-2"><b> x </b></div>
                    </button>
                    `);

                }

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
                            <button value="`+data.data[i].id+`" class="allocated_add flex border-2 border-theme-123 btn_zoo_g mb-2 p-1" style="height: 30px; width:90%; font-size:0.9rem;">
                            <div class="mr-auto">
                                `+data.data[i].u_name+`
                            </div>
                            <div><b> Add </b></div>
                            </button>
                        `);
                    }

                    var trs = `<div class="mt-2 mb-4" style="height: 30px; width:90%; font-size:0.9rem; ">
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
                    <button value="`+data.data[i].id+`"class="allocated_add flex border-2 border-theme-123 btn_zoo_g mb-2 p-1" style="height: 30px; width:90%; font-size:0.9rem;">
                    <div class="mr-auto">
                        `+data.data[i].u_name+`
                    </div>
                    <div><b> Add </b></div>
                    </button>
                `);
            }

            var trs = `<div class="mt-2" style="height:30px; width:90%; font-size:0.9rem; ">
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
                // console.log(('#edit_job_user_id'+data.id+''));
                toastr.error("Worker Already Added");
            }
            else
            {
                // console.log(glb_arr);
                glb_arr.push(data.id);
                // console.log(glb_arr);

                $("#check3").append(`
                <button id="edit_job_user_btn`+data.id+`" value="`+data.id+`"class="remove_btn flex border-2 border-theme-123 btn_zoo_g m-2" style="height: 30px; width:96%; font-size:0.9rem;">
                <input type="hidden" id="edit_job_user_id`+data.id+`" form="update_job_form" value="`+data.id+`" name="id`+data.id+`">
                <div class="mr-auto ml-2">
                    `+data.u_name+`
                </div>
                <div class="mr-2"><b> x </b></div>
                </button>
                `);
            }



            });
        });


        $(document).on("click",".remove_btn",function(e){
            e.preventDefault();
            var id2 = $(this).val();
            // console.log(id2);

            if(confirm("Do you want to remove this worker ?")){
                $('#edit_job_user_btn'+id2+'').remove();

                // console.log(id2);
                for (let i = 0; i < glb_arr.length; i++) {
                    if(glb_arr[i] == id2)
                    {
                        glb_arr.splice(i, 1);
                        break;
                    }
                }
                // console.log(glb_arr);
            }
        });


        $(document).on("submit","#update_job_form", function(event){
            event.preventDefault();
            var id1 = $("#edit_job_company_id").val();
            var id2 = $("#edit_job_location_id").val();

            // console.log(id1,id2);
            $.ajax({
                type:"PUT",
                url:"../edit",
                data: { job_id: get_data, j_location: id2, company_id: id1, job_users: glb_arr },
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
                },
            });
        });

        $(document).on("click", ".delete_job", function(e){
        if(confirm("Do you want to delete this Job ?")){
        $.ajax({
            type: 'DELETE',
            url : '../delete',
            data: { id: get_data,},
        }).done(function(data){
            console.log(data);
            toastr.success("Job Deleted");
            window.location.replace("../../jobs");
        });
        }
        });

    });

</script>


@endsection()
