<?php

    include __DIR__. '/../includes/DatabaseConnection.php';
   function processDates($values){
        foreach($values as $key=>$value){
            if($value instanceof DateTime){
                $values[$key]=$value->format('Y-m-d H:i:s');
            }
        }
        return $values;
    }

    function totaljokes($pdo){
        $stmt=$pdo->prepare('SELECT COUNT(*) FROM `joke`');
        $stmt->execute();

        $row=$stmt->fetch();
        return $row[0];
    }
 

    function getJoke($pdo, $id){
        $stmt = $pdo->prepare('SELECT * FROM `joke` WHERE `id`=:id');
        $values=['id'=> $id];
        $stmt->execute($values);
        return $stmt->fetch();
    }

    function insertJoke($pdo, $values){
        $query='INSERT INTO `joke`(';
        
        foreach($values as $key=> $value){
            $query.= '`'. $key . '`,';
        }    
            $query=rtrim($query, ',');
            $query.=')VALUES(';

        foreach($values as $key=> $value){
            $query.=':'. $key. ',';
        }
            $query=rtrim($query, ',');
            $query.=')';

        $values=processDates($values);
            $stmt=$pdo->prepare($query);
            $stmt->execute($values);
        
    }

   

    function updateJoke($pdo, $values){
        $query='UPDATE `joke` SET ';
        foreach($values as $key=>$value){
            $query.= '`'. $key. '` =:'. $key. ',';      
        }
        $query=rtrim($query, ',');
        $query.= ' WHERE id=:primaryKey';
       
        $values['primaryKey']=$values['id'];
         $values=processDates($values);
        $stmt=$pdo->prepare($query);
        $stmt->execute($values);
    }

    function deleteJoke($pdo, $id){
        $stmt=$pdo->prepare('DELETE FROM `joke` WHERE `id`=:id');

        $values=[':id'=> $id];
        $stmt->execute($values);
    }

    function allJokes($pdo){
        $stmt= $pdo->prepare('SELECT `joketext`, `id`,`jokedate` FROM `joke`');
        $stmt->execute();
        return $stmt->fetchAll();
    }

 //generic functions for all websites begins here 
    function findAll($pdo, $table){
    $stmt=$pdo->prepare('SELECT * FROM `'. $table . '`');
        $stmt->execute();
    return $stmt->fetchAll();
}

function delete($pdo, $table, $field, $value){
    $stmt=$pdo->prepare('DELETE FROM `'. $table . '` WHERE 
                        `'. $field . '`= :value');
    $values=[':value'=>$value];
    $stmt->execute($values);
}

function insert($pdo, $table, $values){
    $query= 'INSERT INTO `'. $table . '` (';
    foreach($values as $key=>$value){
        $query.= '`' . $key . '`,';
    }
    $query=rtrim($query, ',');

    $query.=')VALUES(';

    foreach($values as $key=>$value){
        $query.= ':'. $key . ',';
    }

    $query= rtrim($query, ',');
    $query.=')';

    $values=processDates($values);
    $stmt=$pdo->prepare($query);
    $stmt->execute($values);

}

function update($pdo, $table, $primaryKey, $values){
    $query='UPDATE `'. $table . '` SET';
    foreach($values as $key=>$value){
        $query.= '`'. $key . '`= :'. $key . ',';
    }
    $query=rtrim($query, ',');
    $query.= ' WHERE `'. $primaryKey . '`=:primaryKey';
    $values['primaryKey']= $values['id'];

    $values= processDates($values);
    $stmt=$pdo->prepare($query);
    $stmt->execute($values);
}



function find($pdo, $table, $field, $value){
    $query='SELECT * FROM `' . $table. '` WHERE `'. $field .
    '`=:value';
    $values=['value'=>$value]; 
    $stmt=$pdo->prepare($query);
    $stmt->execute($values);
    return $stmt->fetchAll();
}

function total($pdo, $table) {
 $stmt = $pdo->prepare('SELECT COUNT(*) FROM `' . $table .
'`');
 $stmt->execute();
 $row = $stmt->fetch();
 return $row[0];
}
    

function save($pdo, $table, $primaryKey, $record){
    try{
        if(empty($record[$primaryKey])){
            unset($record[$primaryKey]);
        }
        insert($pdo, $table, $record);
    }
    catch(PDOExecption $e){
        update($pdo, $table, $primaryKey, $record);
    }
}
?>
