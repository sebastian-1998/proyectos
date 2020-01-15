<?php
//incluimos los archivos necesarios
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Usuario.inc.php';
include_once 'app/Entrada.inc.php';
include_once 'app/Comentario.inc.php';
//incluimos los repositorios
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/RepositorioEntrada.inc.php';
include_once 'app/RepositorioComentario.inc.php';
//abrimos la conexion
Conexion::abrir_conexion();
//se crea un ciclo for donde se crea la variable usuarios y 
//hacemos que esta inicie en 0 y sea menor a 100 y en cada iteracion va aumentado en 1
for($usuarios = 0; $usuarios<100; $usuarios++){
    //se crea una variable y como parametro se le pasa la funcion sa y se le pasa el maximo de elementos permitidos para la creacion del nombre
    $nombre = sa(10);
    //al email se le concatena un @ y 3 caracteres mas
    $email = sa(5).'@'.sa(3);
    //hacemos que la password sea estatica pero se encripta
    $password = password_hash('123456', PASSWORD_DEFAULT);
    //se crea un objeto de la clase usuario con los parametros necesarios
    $usuario = new Usuario('', $nombre, $email, $password, '', '');
    //insertamos los datos
    RepositorioUsuario::insertar_usuario(Conexion::obtener_conexion(), $usuario);
}
//metodo para insertar 100 entradas
for($entradas=0; $entradas<100; $entradas++){
    //se crean los parametros necesarios
    $titulo = sa(10);
    //se llama a la funcion que crea un texto
    $texto = lorem();
    //para el autor hacemos que nos genere un numero entre 1 y 100
    $autor = rand(1, 100);
    //hacemos que la url sea igual al titulo
    $url = $titulo;
    //se crea un objeto de la clase entrada con los parametros necesarios
    $entrada = new Entrada('', $autor, $url, $titulo, $texto, '', '');
    //insertamos los datos
    RepositorioEntrada::insertar_entrada(Conexion::obtener_conexion(), $entrada);
}

//insertamos 100 comentarios
for($comentarios=0; $comentarios<100; $comentarios++){
    //se crean los parametros necesarios
    $titulo = sa(10);
    //se llama a la funcion que crea un texto
    $texto = lorem();
    //para el autor hacemos que nos genere un numero entre 1 y 100
    $autor = rand(1, 100);
    //para el autor hacemos que nos genere un numero entre 1 y 100
    $entrada = rand(1, 100);
    //se crea un objeto de la clase entrada con los parametros necesarios
    $comentario = new Comentario('', $autor, $entrada, $titulo, $texto, '');
    //insertamos los datos
    RepositorioComentario::insertar_comentario(Conexion::obtener_conexion(), $comentario);
}

//creamos una funcion que evite que los usuarios puedan repetir sus nombres
function sa($logitud){
    //se crea una variable con todos los caracteres a usar
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //se cuenta cuantos caracteres existen en el string recien creado
    $numero_caracteres = strlen($caracteres);
    $string_aleatorio = '';
    //con un for se crea el string
    for($i=0; $i<$logitud; $i++){
        //se le suman elementos al string_aleatorio
        //rand crea elementos aleatorios
        //-1 evita que se sobrepase el maximo permitido
        $string_aleatorio .=$caracteres[rand(0, $numero_caracteres - 1)];
    }
    //se devuelve el string_aleatorio
    return $string_aleatorio;
}
//funcion para crear un texto
function lorem(){
    $lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vehicula nibh quam. Suspendisse condimentum ante et maximus gravida. Aenean tristique quam lorem, ornare imperdiet massa cursus et. Maecenas ante est, euismod non justo sed, mollis egestas sem. Vivamus quis consectetur felis. Proin bibendum sem eu turpis fermentum, a pellentesque nunc imperdiet. Suspendisse nec ipsum sem. Sed mattis tellus nec ultricies tempus. Suspendisse in ipsum rutrum, sagittis lectus quis, rutrum lectus. Ut id laoreet nulla. Curabitur odio ante, aliquet in diam at, dictum bibendum odio. Vestibulum ac orci ut eros sagittis vulputate. Cras condimentum, turpis et hendrerit vehicula, ligula quam rutrum lacus, vel dictum felis tortor nec elit. Integer ac justo porttitor, viverra nibh eu, euismod massa. Sed pretium et enim ut viverra.

Nulla imperdiet hendrerit bibendum. Vivamus lobortis id nunc et congue. Quisque non lectus convallis, fermentum nulla non, tempor lectus. Donec quis lobortis lorem. Aliquam ultricies massa velit. Pellentesque eget aliquam risus. Proin leo ligula, pharetra in viverra eget, aliquam eu felis. Aenean id ultrices ligula. Curabitur lobortis turpis vel sapien egestas, vitae mollis ipsum vehicula. Morbi eget neque in nunc faucibus vestibulum. Donec vitae sapien at risus sodales cursus. Suspendisse maximus risus dolor, non rhoncus ante efficitur ut. Donec placerat ut lorem ut efficitur. Aliquam volutpat rutrum neque, sed vulputate risus varius id. Mauris tempor ante non lacus suscipit luctus.

Vivamus pellentesque tortor vitae mauris ultrices pellentesque non id lorem. Nulla aliquet arcu in scelerisque consequat. Nulla tincidunt ullamcorper sagittis. Proin vitae dolor ut dolor ornare commodo et nec sapien. Morbi id velit quis nibh facilisis ullamcorper non ut sem. Nulla pulvinar leo sit amet fermentum posuere. Aliquam luctus justo justo, nec maximus purus elementum quis. Integer eleifend, arcu eget congue fringilla, augue dolor tempor sem, in volutpat quam dolor quis turpis. Proin consequat gravida sollicitudin. Integer condimentum augue non justo sollicitudin, eu viverra lectus tristique. In porta lectus vel turpis dapibus, a scelerisque augue hendrerit.

Sed sit amet commodo ligula. Nullam eu urna vitae nisi consequat finibus. Fusce elementum quam sit amet mattis varius. Curabitur tortor risus, ultricies quis magna quis, tristique placerat arcu. Nunc tempus, diam sed tincidunt dapibus, odio quam aliquet sem, ac accumsan tellus ipsum ut sapien. Etiam interdum egestas urna eu sodales. Maecenas vestibulum sodales faucibus. Nullam sollicitudin mauris id ligula imperdiet, vel porttitor sapien porta. Fusce egestas dapibus lorem, quis maximus metus suscipit sed. Aenean dignissim, ante id facilisis placerat, orci sapien mattis odio, vel aliquam lacus arcu quis neque. Donec fermentum justo ut ornare dignissim. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.

Ut in nunc dolor. Praesent gravida gravida ligula nec facilisis. Sed viverra sem sit amet lorem dictum, a euismod est sollicitudin. Nunc tristique nisi sed viverra commodo. Pellentesque lobortis ut ipsum vel venenatis. Quisque ut lacus eget neque vulputate vulputate sed at leo. Nunc eleifend tristique lacinia. Ut ullamcorper dapibus sapien sed tincidunt. Cras pretium condimentum nunc nec sagittis. Integer lacinia augue erat, non ullamcorper justo bibendum id. Praesent cursus velit at risus convallis porttitor. Cras euismod quam ut vehicula aliquam. Nam bibendum eget arcu nec ornare. Pellentesque at vestibulum erat. Aenean et nunc gravida, congue justo in, efficitur arcu.';

    //retornamos el valor
    return $lorem;
}