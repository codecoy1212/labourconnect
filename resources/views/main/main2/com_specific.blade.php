@extends('scripts')

@section('up_title', 'Job Details')
@section('first_ref', 'Jobs')
@section('second_ref', 'Completed')
@section('third_ref', 'Job Details')
@section('pg_act_3', 'breadcrumb--active')
@section('pg_act_jo', 'side-menu--active')

<?php $add = route('jobs');?>
@section('first_add',$add)

<?php $add2 = route('cjob');?>
@section('second_add',$add2)

<?php $add3 = route('sjob',['id' => $vbl9->id]);?>
@section('third_add',$add3)

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-4">
                <div class="intro-y flex items-center h-8 xl:ml-12 xl:mr-12" style="background-color: #edeef0">
                    <h5 style="font-size: 0.975rem; font-weight: bold;" class="ml-3">Completed Job Detail</h5>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="font-weight: bold">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mt-2">
                        Job Number: #{{$vbl9->id}}
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-0 xl:ml-12 xl:mr-12" style="">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y mt-8 mb-2">
                        <div class="mb-1"><b> Company Name</b></div>
                        <div id="edit_job_location_id"></div>
                        <div><b>Company Address</b></div>
                        <div id="edit_job_company_id"></div>

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

        var glb_vbl = "";
        var glb_arr = [];
        var glb_arr_2 = [];

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });


        var get_data = "<?php echo $vbl9->id; ?>";
        // console.log(get_data);

        $.ajax({
            type:"GET",
            url:'../../show/specific/detail',
            data: {id: get_data},
            success: function(data){
                // console.log(data);

                $("#edit_job_location_id").append(``+data[0].c_name+``);
                $("#edit_job_company_id").append(``+data[0].j_location+``);


                for (let i = 0; i < data[1].length; i++) {

                    glb_arr.push(data[1][i].id);
                    glb_arr_2.push(data[1][i].role_id);
                    // console.log(glb_arr);

                    $("#check3").append(`
                    <button id="edit_job_user_btn`+data[1][i].id+`" value="`+data[1][i].id+`&`+data[1][i].role_id+`"class="remove_btn flex border-2 border-theme-123 m-2" style="height: 30px; width:96%; font-size:0.9rem;">
                    <input type="hidden" id="edit_job_user_id`+data[1][i].id+`" form="update_job_form" value="`+data[1][i].id+`" name="id`+data[1][i].id+`">
                    <div class="mr-auto ml-2">
                        `+data[1][i].u_name+` | `+data[1][i].r_name+`
                    </div>
                    <div class="mr-2"><b> x </b></div>
                    </button>
                    `);

                }
                // console.log(glb_arr);
                // console.log(glb_arr_2);

            },
            error: function(error){
                // console.log(error);
            },
        });

    });

</script>


@endsection()
