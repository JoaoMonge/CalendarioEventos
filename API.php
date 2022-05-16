<?php


/* REST API -
An API, or application programming interface,
is a set of rules that define how applications
or devices can connect to and communicate with each other.
A REST API is an API that conforms to the design principles of the REST,
or representational state transfer architectural style. For this reason,
REST APIs are sometimes referred to RESTful APIs.
*/

require "connect.php";


//Quando alguma aplicacao emitir um pedido HTTP GET com o parametro action get_events vai obter esta resposta
if( isset($_GET["action"]) ){
    if($_GET["action"] == "get_events"){
        //IR À BASE DE DADOS E DEVOLVER A LISTA DE EVENTOS
        $query = "SELECT * FROM Evento";
        $res = mysqli_query($conn,$query);


        $arr = array();

        //Percorrer todos os eventos que estão na base de dados guardados
        while ($row = mysqli_fetch_assoc($res) ){

            if($row["cancelled"] == "0"){
                $row["cancelled"] = false;
            }else{
                $row["cancelled"] = true;
            }

            array_push($arr,$row);

        }

        //Preparar o json para estar de acordo com o que o calendario espera
        $js_toEncode = ["events"=>$arr];

        //Codificacao em json para passar pela rede internet
        $js = json_encode($js_toEncode);

        echo $js;
    }
}

//Responder a um pedido post para guardar um evento novo na base de dados
if( isset($_POST["year"]) && isset($_POST["occasion"]) && isset( $_POST["invited_count"] ) && isset( $_POST["month"]) && isset( $_POST["day"]))
{


    //Preparar a query e proteger de SQL Injection
    $query = $conn->prepare("INSERT INTO Evento (occasion,invited_count,year,month,day,cancelled) VALUES (?,?,?,?,?,false);");
    $query->bind_param("sdddd", $_POST["occasion"], $_POST["invited_count"], $_POST["year"], $_POST["month"], $_POST["day"]);
    $query->execute();



    if (mysqli_error($conn)) {
        echo json_encode('{"message":"this is erro a teste"}');
    }

}

?>