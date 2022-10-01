<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/../css/style-adss.css">
    <title>adss</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
        h1{
            color: red;
        }
        body{
            display: flex;
            flex-direction: column;
            font-family: 'Roboto';
            color: white;
            background-color: lightgray;
        }
        form{
            padding: 2%;
            margin: 1%;
            margin-bottom:0;
            display: flex;
            flex-direction: row;
            width: 70%;
            align-items:center;
            justify-content: space-between;
            background-color: darkgray;
            border-radius: 0 20px 20px 0; 
        }
        form.creation{
            width:40%;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 1%;
        }
        .column{
            display: flex;
            flex-direction: column;
        }
        .delete{
            width:10%;
            margin-top: 0%;
            margin-bottom: 1%;
            border-top-right-radius: 0;
        }
    </style>
    </head>
    <body>
        <h1>Backoffice ads's Administration</h1>
        <form method="POST" action="/api/ads/create" class="creation">
                <h2 style="color:black">Create an ads</h2>
                <label>
                    Image:
                    <input name="image" type="text" value="">
                </label>
                <label>
                    Url:
                    <input name="url" type="text" value="">
                </label>
                <label>
                    Size:
                    <input name="size" type="text" value="">
                </label>
                <label>
                    Views hired:
                    <input name="views_hired" type="text" value="">
                </label>
                <label>
                    Tag:
                    <input name="tag" type="text" value="" maxlength="8">
                </label>

            <input type="submit">
        </form>
        <h2 style="color:red;font-size:2em;">ads's List</h2>
        @foreach($ads as $ad)
            <form class="entry" method="POST" action="/api/ads/{{$ad->id}}">
                @method('PUT')
                @csrf
                {{method_field('PUT')}}
                <div class="column">
                    <input name="_method" type="hidden" value="PUT">
                    <label>
                        image:
                        <input type="text" name="image" value="{{$ad->image}}">
                    </label>
                    <label>
                        url:
                        <input type="text" name="url" value="{{$ad->url}}">
                    </label>
                    <label>
                        size:
                        <input type="text" name="size" value="{{$ad->size}}">
                    </label>
                    <label>
                        views hired:
                        <input type="number" name="views_hired" value="{{$ad->views_hired}}">
                    </label>
                    <label>
                        views counter:
                        <input type="text" name="views_counter" value="{{$ad->view_counter}}">
                    </label>
                    <label>
                        tag:
                        <input type="text"name="tag" value="{{$ad->tag}}">
                    </label>
                </div>
                <input type="submit">
                </form>
                <form action="/api/ads/{{$ad->id}}"method="POST" class="delete">
                    @method('DELETE')
                    @csrf
                    {{method_field('DELETE')}}
                    <input name="_method" type="hidden" value="DELETE">
                    <input type="submit" value="DELETE">
                </form>
                @endforeach
    </body>
</html>