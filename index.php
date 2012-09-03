<html>
<head>
    <title>Tweet Meme API</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <style type="text/css">
        #results{border:1px solid #ddd;box-shadow:2px 2px 2px rgba(0,0,0,0.5);display:none;font-family:arial;}
        #results td a {color:#333;text-decoration:none;font-family:arial;}
        #results td a:hover{text-decoration:underline;}
    </style>
</head>

<body>

    <table border=0>
        <tr>
        <td><select id="categories" name="categories"></select>
        <td><input type="button" id="button" value="Submit">
        </tr>
    </table>

    <table id="results" cellspacing="3" cellpadding="3">
    </table>

<script type="text/javascript">
var category;
$(document).ready(function(){
    $.ajax({
        type:'POST',
        url:'tweetMemeProxy.php',
        data:'url=http://api.tweetmeme.com/stories/categories.json',
        dataType:'json',
        success:function(data){
            for(var i in data.categories){
                $("#categories").append('<option value="' + data.categories[i].name + '">'+data.categories[i].display + '</option>');
            }
        }
    });
    
    $("#button").click(function(){
        category = $("#categories").val();
        getStories();
    });
});

var getStories = function(){
    var storyUrl='http://api.tweetmeme.com/stories/popular.json?category=';
    $.ajax({
        type:'POST',
        url:'tweetMemeProxy.php',
        data:'url='+storyUrl+$("#categories").val(),
        dataType:'json',
        success:function(data){
            $("#results").html(createTableHeader());
            for(var i in data.stories){
                $("#results").append(addTableRow(data.stories[i]));
            }
        },
        complete:function(xhr, status){
            if(status =='success'){
                setInterval(getStories,60000);
                $("#results tr:even").css({"background-color":"#ededed"});
                $("#results").show();
            }
        }
    });
};

function createTableHeader()
{
    var html='<tr>';
    html+='<th>Title</th>';
    html+='<th>Created At</th>';
    html+='<th>Retweets</th>';
    html+='<th>TM Comments</th>';
    return html;
}

function addTableRow(row)
{
    var html = '<tr>';
    html+= '<td>'+ createStoryLink(row.url,row.title) + '</td>';
    html+= '<td>'+ row.created_at + '</td>';
    html+= '<td>'+ row.url_count + '</td>';
    html+= '<td>'+ row.comment_count + '</td>';
    html+= '</tr>';
    return html;
}

function createStoryLink(url,title)
{
    return '<a href="'+url+'">'+title+'</a>';
}
</script>
</body>
</html>
