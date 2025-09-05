<?php 
class DatabaseTable{

    public function total($pdo, $table){
        $stmt=pdo->prepare('SELECT COUNT(*) FROM `' . $table. '`');
        $stmt->execute();
        $row=$stmt->fetch();
        return $row[0];
    }


    public function find($pdo, $table, $field , $value){
        $query='SELECT * FROM `'. $table .'` WHERE `'. $field .
                '` = :value' ;
        $values=[
            'value'=> $value
        ];

        $stmt=pdo->prepare($query);
        $stmt->execute($values);
        return $stmt->fetchAll();
    }

    private function insert($pdo, $table, $values){
        $query= 'INSERT INTO `'. $table . '` (';
        
        foreach($values as $key=>$value){
            $query.= '`'. $key . '`,';
        }
        $query=rtrim($query, ',');
        $query.= ')VALUES(';

        foreach($values as $key=>$value){
            $query.= ':'. $key . ',';
        }
        $query= rtrim($query, ',');
        $query.=')';

        $values=$this->processDates($values);
        $stmt=$pdo->prepare($query);
        $stmt->execute($values);
        }

    private function update($pdo, $table, $primaryKey, $values){
        $query= 'UPDATE `' $table '` SET ';
        
        foreach($values as $key=>$value){
            $query.= '`'. $key . '` =:'. $key . ','; 
        }
        $query= rtrim($query, ',');
        $query.= ' WHERE `'. $primaryKey. '` =:primaryKey';

        $values['primaryKey']= $values['id'];
        $values= $this->processDates($values);

        $stmt= $pdo->prepare($query);
        $stmt->execute($values);
    }

    public function delete($pdo, $table, $field, $value){
        $values= [':value'=>$value];

        $stmt=$pdo->prepare('DELETE FROM `'. $table . '` WHERE `'.
        $field . '` =:value');

        $stmt->execute($values);
    }

    public function findAll($pdo, $table){
        $stmt=$pdo->prepare('SELECT * FROM `'. $table .'`');
        $stmt->execute();

        return $stmt->fetchAll();
    }

    private function ProcessDates($values){
        foreach($values as $key=>$value){
            if($value instanceof DateTime){
                $values[$key]= $value->format('y-m-d');
            } 
        }
        return $values;
    }

    public function save($pdo, $table, $primaryKey, $record){
        try{
            if(empty($recordd[$primaryKey])){
                unset($record[$primaryKey]);
            }
            $this->insert($pdo, $table, $record);
        }
        catch(PDOExecption $e){
            $this->update($pdo, $table, $primaryKey, $record);
        }
    }
    
    }    
    
?>