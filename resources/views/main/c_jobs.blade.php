@extends('scripts')

@section('up_title', 'Completed')
@section('first_ref', 'Jobs')
@section('second_ref', 'Completed')
@section('pg_act_2', 'breadcrumb--active')
@section('pg_act_jo', 'side-menu--active')

<?php $add = route('jobs');?>
@section('first_add',$add)

<?php $add = route('cjob');?>
@section('second_add',$add)

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="text-center col-span-12 mt-4">
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mg-20">
                    <a class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y" href="{{route('jobs')}}">
                        <div class="zoom-in">
                            <div class="box border-3">
                                <div class="flex">
                                    {{-- <i style="width:43px; height:43px;" data-feather="user" class="report-box__icon text-theme-1 m-auto"></i> --}}
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-5">
                                    {{$vbl4}}

                                </div>
                                <div class="text-3xl leading-8 mb-5">Active Jobs</div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y" href="{{route('njob')}}">
                        <div class="zoom-in">
                            <div class="box border-3">
                                <div class="flex">
                                    {{-- <i style="width:43px; height:43px;" data-feather="layers" class="report-box__icon text-theme-1 m-auto"></i> --}}

                                </div>
                                <div class="text-3xl eading-8 mt-10 mb-10">Create Job</div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y" href="{{route('cjob')}}">
                        <div class="zoom-in">
                            <div class="box border-3">
                                <div class="flex">
                                    {{-- <i style="width:43px; height:43px;" data-feather="user" class="report-box__icon text-theme-1 m-auto"></i> --}}
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-5">
                                    <div id="check2" ></div>
                                </div>
                                <div class="text-3xl leading-8 mb-5">Archived Jobs</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="intro-y flex items-center h-8 mt-6 mb-6 xl:ml-12 xl:mr-12" style="background-color: #edeef0">
                    <h5 style="font-size: 0.975rem; font-weight: bold;" class="ml-3">Completed Jobs</h5>
                </div>
                <div id="check1" class="grid grid-cols-12 gap-6 xl:col-span-2 intro-y xl:ml-12 xl:mr-12">

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

            get_fun();
            function get_fun()
            {
                $.ajax({
                method: "GET",
                url: "collection/show/completed",
                success: function (data) {
                    // console.log(data);
                    $("#check2").append(``+data.length+``);

                    for (let i = 0; i < data.length; i++) {
                        $("#check1").append(`
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">

                            <div class="zoom-in">
                                <div class="box border-3" style="text-align: left; font-size: 0.9rem; line-height: 2.0;" >
                                    <div class="flex pl-2" style="background-color: black; min-height: 30px; color:white;">
                                    </div>

                                    <a href="../jobs/completed/show/`+data[i].id+`">
                                    <div class="m-2">
                                        <div><b>Client: </b>`+data[i].c_contact+`</div>
                                        <div><b>Location: </b>`+data[i].j_location+`</div>
                                        <div><b>Active Workers: </b>`+data[i].workers_count+`</div>
                                    </div>
                                    </a>

                                    <div class="flex mt-2 mb-0" style="min-height: 2px; background-color:black;">
                                    </div>
                                    <div class="flex ml-2">
                                        <b>#`+data[i].id+`</b>
                                    </div>
                                </div>
                            </div>
                        </div>`);
                        // console.log("hello");
                        //
                    }

                    for (let i = 0; i < data.length; i++) {
                        $('#deletejob_'+data[i].id+'').val(data[i].id);
                        $('#completejob_'+data[i].id+'').val(data[i].id);
                    }
                },
                error: function(error){
                    console.log(error);
                }
                });
            }

            $(document).on("click",".delete_job", function(e){
            e.preventDefault();

            var id2 = $(this).val();
            // console.log(id2);

            if(confirm("Do you want to remove this Job?")){
                $.ajax({
                    type: 'DELETE',
                    url : 'jobs/delete',
                    data: { id: id2,},
                }).done(function(data){
                    // console.log(data);
                    toastr.success("Job Deleted");
                    $("#check1").empty();
                    get_fun();
                });
            }

            });

            $(document).on("click",".mark_complete",function(e){
                e.preventDefault();
                // console.log("COMPLETE");
                var id2 = $(this).val();
                console.log(id2);

                if(confirm("Mark this job as complete?")){
                $.ajax({
                    type: 'PUT',
                    url : 'jobs/collection/show/complete',
                    data: { id: id2,},
                }).done(function(data){
                    console.log(data);
                    toastr.success("Job Deleted");
                    $("#check1").empty();
                    get_fun();
                });
                }

            });

        });

    </script>

@endsection()
