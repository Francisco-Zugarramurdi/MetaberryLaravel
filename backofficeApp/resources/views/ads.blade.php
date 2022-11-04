<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Ads</title>
</head>
<body>
    <main>

        @include('navbar')


        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>Ads Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create ads 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create ads</h2>
    
                        <form action="/ads/create" class="create-user-form" method="POST" id="creationForm" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            
                            <div class="form-up-container">
    

                                    <div class="form-inner-container">
        
                                    <label>
                                        <p><span>* </span>Ad image</p>
                                        <input type="file" name="image" accept="image/*" id="imageInput" class="input-image">
                                        <label for="imageInput" class="label-image">
                                            <span class="material-symbols-outlined">upload</span>
                                            <p>Upload an image...</p>
                                        </label>
                                    </label> 

                                    
                                        <label>
                                            <p><span>* </span>Url</p>
                                            <input type="text" name="url" placeholder="Futbol.com" id="url">
                                        </label>

                                        <label>
                                            <p><span>* </span>Size</p>
                                            <select name="size" id="size">
                                                <option value="small">Small</option>
                                                <option value="medium">Mid-large</option>
                                                <option value="large">Large</option>
                                                <option value="wide">Wide</option>
                                                <option value="square">Square</option>
                                            </select>
                                        </label>
        
                                        <label>
                                            <p><span>* </span>Views hired</p>
                                            <input type="number" name="viewsHired" placeholder="100" id="viewsHired">
                                        </label>

                                    </div>

                                    <div class="form-inner-container">

                                        <label>
                                            <p><span>* </span>Tag</p>
                                        </label>

                                        <div class="tag-container">

                                            @foreach($tags as $tag)
                                            <label>
                                                <p>{{$tag->tag}}</p>
                                                <input type="checkbox" name="tag[]" id="tag" value="{{$tag->tag}}">
                                            </label>
                                            @endforeach

                                        </div>

                                    </div>
    
                            </div>
    
                            <div class="form-down-container">
    
                                <input type="submit" value="Create" class="create-btn" id="submit">
            
                                <div id="error" class="error"></div>
    
                            </div>
    
                        </form>
                    
                </div>

            </div>

            <div class="user-table-container">

                <table class="user-table">

                    <thead>
                        <tr>

                            <th>ID</th>
                            <th>Preview</th>
                            <th>Image</th>
                            <th>Url</th>
                            <th>Size</th>
                            <th>Views hired</th>
                            <th>Tag</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ads as $ad)
                            <tr>
                                    <form class="entry" method="POST" action="/ads/{{$ad->id}}" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$ad->id}}</p>

                                        </td>

                                        <td class="user-profile-pic ad">

                                            <div class="image-container">
                                                <img src="{{ asset('img/public_images').'/'.$ad->image }}" alt="">
                                            </div>

                                        </td>

                                        <td class="user-image">
                                            <label class="custom-selector">
                                                <input type="file" name="image" accept="image/*" id="{{$ad->id}}" class="input-image">
                                                <label for="{{$ad->id}}" class="label-image">
                                                    <span class="material-symbols-outlined">upload</span>
                                                    <p>Change image...</p>
                                                </label>
                                            </label>
                                        </td>
                                        
    
                                        <td class="user-name">
                                            <label>
                                                <input name="url" type="text" value="{{$ad->url}}">
                                            </label>
                                        </td>
                                        
                                        <td class="user-type">
                        
                                            <label>
                                                <select name="size" id="size">
                                                <option value="small" @if($ad->size == "small") selected @endif >Small</option>
                                                <option value="medium" @if($ad->size== "medium") selected @endif >Mid-large</option>
                                                <option value="large" @if($ad->size == "large") selected @endif >Large</option>
                                                <option value="wide" @if($ad->size == "wide") selected @endif >Wide</option>
                                                <option value="square" @if($ad->size== "square") selected @endif >Square</option>
                                                </select>
                                            </label>
                                        </td>

                                        <td class="user-points">
                                            <label>
                                                <input type="number" name="viewsHired" value="{{$ad->views_hired}}">
                                            </label>
                                        </td>
    
                                        <td class="tag-container-show">

                                            <div class="tag-container-table">

                                                @foreach($tags as $tag)
                                                <label>
                                                    <p>{{$tag->tag}}</p>
                                                    <input type="checkbox" name="tag[]" id="tag" value="{{$tag->tag}}"
                                                    @foreach($adsModal as $modal)
                                                    @if($tag->tag == $modal->tag)
                                                        @if($modal->id == $ad->id)
                                                        checked
                                                        @endif
                                                    @endif
                                                    @endforeach>
                                                </label>
                                                @endforeach

                                            </div>

                                        </td>
    
                                        <td class="actions-buttons">
                                            <!-- <button type="button" class="edit-input-btn" onClick="editFormInput()"></button> -->
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit({{$ad->id}})">
                                            <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                    </form>

                                <form action="/ads/{{$ad->id}}"method="POST" class="delete" id="delete_form_{{$ad->id}}">
                                    @method('DELETE')
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <input name="_method" type="hidden" value="DELETE">
                                </form>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                {{$ads->links()}}
            </div>

        </div>

    </main>

    <script>


        const deleteFormSubmit = (id) =>{

            event.preventDefault();
            document.getElementById('delete_form_'+id).submit();

        }
        
    </script>
    <script>
        document.getElementById('ads').classList.add("focus");
    </script>
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script>
</body>
</html>