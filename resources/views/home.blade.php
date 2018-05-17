@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{--form to upload products--}}
                        <form method="POST" action="{{ route('upload_product') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="product_name" class="col-md-3 col-form-label">Product Name:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control {{ $errors->has("name")? ' invalid':'' }}"
                                           id="name" name="name">
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback">
                                         {{ $errors->first('name') }}
                                       </span>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-md-3 col-form-label">Category</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control {{ $errors->has("category")?' invalid':'' }}"
                                           id="category" name="category">

                                    @if($errors->has('category'))
                                        <span class="invalid-feedback"> {{ $errors->first('category') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-3 col-form-label">
                                    Description
                                </label>
                                <div class="col-md-7">
                                    <textarea class="form-control {{ $errors->has('description')? ' invalid':'' }}"
                                              id="description" name="description"></textarea>

                                    @if($errors->has('description'))
                                        <span class="invalid-feedback"> {{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-3 col-form-label">Price</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control {{ $errors->has("price")?' invalid':'' }}"
                                           id="price" name="price">

                                    @if($errors->has('price'))
                                        <span class="invalid-feedback"> {{ $errors->first('price') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="photo" class="col-md-3 col-form-label"> Images</label>
                                <div class="col-md-7">
                                    <input type="file" class="form-control {{ $errors->has("photo")?' invalid':'' }}"
                                           id="photo" name="photo[]" multiple>

                                    @if($errors->has('photo'))
                                        <span class="invalid-feedback"> {{ $errors->first('photo') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-7 offset-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
