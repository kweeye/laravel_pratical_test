@extends('layouts.app')
@section('content')
<div class="container" id="contactApp">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Public Form</div>
                <form action="" method="POST" accept-charset="UTF-8">
                {!! csrf_field() !!}
                <div class="card-body">
                    <div v-if="success_alert" class="alert alert-success" role="alert">
                        @{{success_alert}}
                    </div>
                    @foreach($form_render as $form)
                        @if($form->form_name == 'name')
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">{{$form->label}}</label>
                                <input v-model="requestData.name" type="{{$form->field}}" class="form-control" id="exampleFormControlInput1">
                                @if($form->form_name == 'name')
                                    <small class="text-danger">@{{err.name}}</small>
                                @endif
                            </div>
                        @endif
                        @if($form->form_name == 'phone_number')
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">{{$form->label}}</label>
                                <input v-model="requestData.phone_number" type="{{$form->field}}" class="form-control" id="exampleFormControlInput1">
                                @if($form->form_name == 'phone_number')
                                    <small class="text-danger">@{{err.phone_number}}</small>
                                @endif
                            </div>
                        @endif
                        @if($form->form_name == 'dob')
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">{{$form->label}}</label>
                                <input v-model="requestData.dob" type="{{$form->field}}" class="form-control" id="exampleFormControlInput1">
                                @if($form->form_name == 'dob')
                                    <small class="text-danger">@{{err.dob}}</small>
                                @endif
                            </div>
                        @endif
                        @if($form->form_name == 'gender')
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">{{$form->label}}</label>
                                <select v-model="requestData.gender" class="form-select" aria-label="Default select example">
                                    <option value="">Open this select menu</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @if($form->form_name == 'gender')
                                    <small class="text-danger">@{{err.gender}}</small>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
                </form>
                <div class="card-footer">
                        <button type="submit" class="btn btn-success" @click="contactStore"><i class="fas fa-save"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
<script>
    var app = new Vue({
        el:'#contactApp',
        data:{
            success_alert: "",
            requestData: {
                form_field: [],
                name: "",
                phone_number: "",
                dob: "",
                gender: ""
            },
            err:{
                name: "",
                phone_number: "",
                dob: "",
                gender: ""
            }
        },
        methods:{
            formData() {
                let vm = this;
                axios.get('/api/form-field').then((res) => {
                    vm.requestData.form_field = res.data.data
                });
            },
            contactStore: function () {
                let vm = this;
                axios.post('/api/contact-info-store', {
                    form_field: vm.requestData.form_field,
                    name: vm.requestData.name,
                    phone_number: vm.requestData.phone_number,
                    dob: vm.requestData.dob,
                    gender: vm.requestData.gender
                })
                .then(function (res) {
                    if(res.data.status == false){
                        if(res.data.data.name){
                            vm.err.name = res.data.data.name[0]
                        }
                        if(res.data.data.phone_number){
                            vm.err.phone_number = res.data.data.phone_number[0]
                        }
                        if(res.data.data.dob){
                            vm.err.dob = res.data.data.dob[0]
                        }
                        if(res.data.data.gender){
                            vm.err.gender = res.data.data.gender[0]
                        }
                        
                    }else{
                        vm.err.name = ""
                        vm.err.phone_number = ""
                        vm.err.dob = ""
                        vm.err.gender = ""
                        vm.requestData.name = ""
                        vm.requestData.phone_number = ""
                        vm.requestData.dob = ""
                        vm.requestData.gender = ""
                        vm.success_alert = "Contact Info Is Success"
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted(){
            let vm = this;
            vm.formData()
        }
    });
</script>
@stop
