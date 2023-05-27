@extends('admin/layout')
@section('page_title','Manage Size')
@section('size_select','active')
@section('container')

<h1 class="mb-10">Manage Size</h1>
<a href="{{url('admin/size')}}">
    <button type="button" class="btn btn-success">Back</button>

</a>

            <!-- MAIN CONTENT-->
           
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                <div class="card">
                                    
                                    <div class="card-body">                                       
                                        
     <form action="{{route('size.manage_size_process')}}" method="post">
       @csrf
            <div class="form-group">
             <label for="category_name" class="control-label mb-1">Size</label>
              <input id="size" name="size" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$size}}" required>

               @error('size')
               <div class="alert alert-danger">    
                {{$message}}
                </div>
                @enderror
               </div>                             
               <div>
               <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">                                                  
               Submit
               </button>
            </div>
           <input type="hidden" name="id" value="{{$id}}">
          </form>
          </div>
         </div>
       </div>
     </div>                           

@endsection
