@include('header')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{Vite::asset('resources/views/style.css')}}">

<?php
$hash = isset($_GET['hash']) ? $_GET['hash'] : '';

if ($hash === 'love') {
    ?>
    @include('tovar')
    <?php
} elseif ($hash === 'roman') {
    ?>
    @include('roman')
    <?php
} else {
    echo "Выберите категорию";
}
?>

<script>
    let hash = window.location.hash.substring(1);
    
    if (hash) {
      
        window.location.href = window.location.pathname + "?hash=" + hash;
    }
</script>