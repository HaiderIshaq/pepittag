@extends('layouts.app')
    


@section('content')
<div class="container-fluid">
   
    <div class="row">

        <div class="col-md-12 mt-3">
            <h4>
                <b>Upload Jobs in bulk</b>
            </h4>

                <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-2 mb-2">
                        <div class="col-md-12">
                            <input type="file" name="csv">
                        </div>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="1">
                                <label class="form-check-label" for="inlineRadio1">Cooler / Freezer</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="2">
                                <label class="form-check-label" for="inlineRadio2">Vehicle</label>
                              </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary btn-sm" value="Submit">
              </form>

        </div>

    </div>

</div>


@endsection
