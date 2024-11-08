@extends('layout.master')

@php
    $active = 'indexPages';
@endphp

@section('title')
    صفحات:
@endsection

@section('content')
    <ol class="breadcrumb" style="direction: ltr;justify-content: right;">
        <li class="breadcrumb-item active">لیست صفحات</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
    </ol>
    <div class="wrapper container">
        <div class="d-flex row" >
            <div class="col-6 mb-2" style="text-align: justify;">
               <button type="button" class="btn btn-primary mr-0" data-toggle="modal" data-target="#createPageModal">
                   ایجاد صفحه جدید
               </button>
               <a href="{{ route('pages.trash') }}" class="btn btn-secondary " style="max-width: fit-content">
                   <i class="fa fa-trash"></i>
                   سطل آشغال
               </a>
            </div>
            <div class="col-6 mb-2" style="justify-items: end;">
                <form class="ml-0" action="{{ route('pages.search') }}" method="GET">
                    <input type="text" class="form-control" placeholder="جستجو بین صفحات" style="width: 250px" value="{{ request()->has('keyword') ? request()->keyword : '' }}" name="keyword">
                </form>
            </div>

            <div class="modal fade" id="createPageModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ایجاد صفحه:</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <div class="modal-body text-right">
                                <form action="{{ route('pages.create') }}" method="GET">
                                @include('layout.errors', ['errors' => $errors->validatingBasicInfo])
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="title">عنوان:</label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="status" class="form-label">وضعیت:</label>
                                        <input type="number" name="status" class="form-control" id="status" value="{{ old('status') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-md-3 form-control-label" for="category_id">دسته بندی:</label>
                                        <div class="col-md-9">
                                            <select id="category_id" name="category_id" class="form-control input-lg">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" style="margin-top: 65px;">
                                    <div class="form-group">
                                        <label class="col-md-3 form-control-label" for="select">فعال:</label>
                                        <div class="col-md-9">
                                            <select id="is_active" name="is_active" class="form-control input-lg">
                                                <option value="1" selected>فعال</option>
                                                <option value="0">غیرفعال</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
                                <button type="submit" class="btn btn-primary">ادامه</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <table class="table col-12">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">دسته بندی</th>
                    <th scope="col">فعال</th>
                    <th scope="col">تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $key => $page)
                    <tr>
                        <th scope="row">{{ $pages->firstItem() + $key }}</th>
                        <td class="text-right">{{ $page->title }}</td>
                        <td class="text-right">{{ $page->category->title }}</td>
                        <td class="text-right">{{ $page->is_active == 1 ? 'فعال' : 'غیرفعال' }}</td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                    تنظیمات
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('pages.show', ['page' => $page]) }}">
                                        نمایش
                                    </a>
                                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#editPageModal-{{ $page->id }}">
                                        ویرایش
                                    </button>
                                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#deletePageModal-{{ $page->id }}">
                                        حذف
                                    </button>
                                </div>
                            </div>
                        </td>
                        <div class="modal fade" id="editPageModal-{{ $page->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ویرایش صفحه: {{ $page->title }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-right">
                                        <form action="{{ route('pages.edit', ['page' => $page]) }}" method="GET">
                                            @include('layout.errors', ['errors' => $errors->updateBasicInfo])
                                            <input type="hidden" class="form-control" name="page_id" value="{{ $page->id }}">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">عنوان:</label>
                                                    <input type="text" class="form-control" name="title" id="title" value="{{ $page->title }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="status" class="form-label">وضعیت:</label>
                                                    <input type="number" name="status" class="form-control" id="status" value="{{ $page->status }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 form-control-label" for="category_id">دسته بندی:</label>
                                                    <div class="col-md-9">
                                                        <select id="category_id" name="category_id" class="form-control input-lg">
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}" {{ $page->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12" style="margin-top: 65px;">
                                                <div class="form-group">
                                                    <label class="col-md-3 form-control-label" for="select">فعال:</label>
                                                    <div class="col-md-9">
                                                        <select id="is_active" name="is_active" class="form-control input-lg">
                                                            <option value="1" {{ $page->is_active == 1 ? 'selected' : '' }}>فعال</option>
                                                            <option value="0" {{ $page->is_active == 0 ? 'selected' : '' }}>غیرفعال</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
                                        <button type="submit" class="btn btn-primary">ویرایش</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deletePageModal-{{ $page->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">حذف صفحه: {{ $page->title }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-right">
                                        آیا از حذف صفحه مطمعن هستید؟
                                    </div>
                                    <form action="{{ route('pages.destroy', ['page' => $page]) }}" method="POST">
                                        <div class="modal-footer">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
                                            <button type="submit" class="btn btn-primary">حذف</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
