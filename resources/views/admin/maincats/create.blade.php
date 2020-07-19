@extends('layouts.admin')

@section('content')

    <div class="app-content content">
        <div class="content-wrapper">

            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('main-cats.index') }}"> الاقسام
                                        الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active"> إضافة قسم رئيسي
                                </li>
                            </ol>

                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form" style="color: #9f191f">إضافة قسم رئيسي
                                        للمتجر </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">

                                        <form class="form" action="{{route('main-cats.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-body">

                                                <h4 class="form-group"><i class="ft-home"></i> بيانات القسم </h4>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label> صوره القسم
                                                        </label>
                                                        <input type="file" value="" id="file"
                                                               class="form-control"
                                                               placeholder=""
                                                               name="photo">
                                                        @error("photo")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <hr>
                                                <br>

                                                @if(getActiveLang() -> count() > 0)
                                                    @foreach(getActiveLang() as $index => $lang)
                                                        {{-- TO Get All Activted Languages and loop all--}}

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label> اسم القسم
                                                                        - {{__('site.'.$lang -> abbr)}} </label>
                                                                    <input type="text" value="" id="name"
                                                                           class="form-control"
                                                                           placeholder=""
                                                                           name="category[{{$index}}][name]">
                                                                    @error("category.$index.name")
                                                                    <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            {{-- Will be hidden and make default value --}}
                                                            <div class="col-md-6 hidden">
                                                                <div class="form-group">
                                                                    <label> أختصار اللغة
                                                                        - {{__('site.'.$lang -> abbr)}}
                                                                    </label>
                                                                    <input type="text" id="abbr"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           value="{{$lang -> abbr}}"
                                                                           name="category[{{$index}}][abbr]">

                                                                    @error("category.$index.abbr")
                                                                    <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group mt-1">
                                                                    <input type="checkbox" value="1"
                                                                           name="category[{{$index}}][active]"
                                                                           id="switcheryColor4"
                                                                           class="switchery" data-color="success"
                                                                           checked/>
                                                                    <label for=""
                                                                           class="card-title ml-1">الحالة {{__('site.'.$lang -> abbr)}}
                                                                    </label>

                                                                    @error("category.$index.active")
                                                                    <span class="text-danger"> هذا الحقل مطلوب </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                @endif
                                            </div>

                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> حفظ
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@endsection
