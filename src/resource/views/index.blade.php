<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plugin Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset(\Skintrphoenix\PluginLoader\PluginIds::LINK_RESOURCE . '/css/main.css') }}">
  </head>
  <body style="background: #E9F8F9;">

    <nav class="navbar navbar-expand-lg navbar-dark p-3" style="background: #92d7de;">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Plugin Settings</a>
        </div>
      </nav>

      <main class="mt-5 p-3">
        <section class="container-fluid">
            <div class="row justify-content-center col-12 col-xl-12 col-md-12 col-sm-12 gap-3 mb-4 mx-auto">
                @foreach ($plugins as $plugin)
                <div class="row justify-content-center col-12 col-xl-4 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                    <img src="{{ asset('storage/' . $plugin->plugin->name . '.png') }}" style="max-width: 90px; max-height: 90px;" alt="...">
                                    <br><small>{{ $plugin->plugin->author }}</small>
                                </div>
                                <div class="col-xl-8 col-lg-4 col-md-8 col-sm-8 col-8">
                                    <h3>{{ $plugin->plugin->name }} <span class="h4">v{{ $plugin->plugin->version }}</span></h3>
                                    <p>{{ $plugin->plugin->description }}</p>
                                    <p class="text-end">
                                        <label class="switch">
                                            <input type="checkbox" name="plugin[]" class="plugin" value="{{ $plugin->plugin->name }}" {{ (is_null(\Skintrphoenix\PluginLoader\Models\Plugin::where('name', $plugin->plugin->name)->first())) ? '' : 'checked'}}>
                                            <span class="slider"></span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </section>
      </main>


      <footer class="container-fluid" style="background: #92d7de;">
        <div class="w-75 p-3 mx-auto row col-xl-12 justify-content-center"></div>

        <div class="col-xl-12 text-center text-white pb-4">
          &copy; 
        </div>
      </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
          $('.plugin').change(function(){
            const val = this.value;
            const type = $(this).prop('checked') ? 'load' : 'unload';
            console.log(this);
            $.ajax({
              url: '{{ route('plugins.update', 'plugin') }}',
              data:{
                'name': val,
                'token': '{{ csrf_token() }}',
                type: type
              },
              type: 'PUT',
              success: function(data){
                console.log('berhasil update');
                console.log(data);
              }
            });
          })
        })
    </script>
  </body>
</html>
