<div class="row">
    <div class="col-lg-12">
        @if (session('success'))
            <div class="alert alert-success fade show alert-with-icon" role="alert">
                {{ session('success') }}
                <button type="button" class="close" aria-hidden="true" data-dismiss="alert" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
            </div>            
        @endif
        @if (session('warning'))
            <div class="alert alert-warning alert-with-icon fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="close" aria-hidden="true" data-dismiss="alert" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
            </div>            
        @endif 
        @if (session('error'))
            <div class="alert alert-danger alert-with-icon fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" aria-hidden="true" data-dismiss="alert" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
            </div>            
        @endif
    </div>    
</div>
<div class="row">
    <div class="col-lg-12">
        @if (count($errors) > 0)
            <div class="alert alert-danger alert-with-icon fade show" role="alert">                
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach                
            </div>
        @endif
    </div>    
</div>
