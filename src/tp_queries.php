<?php
    class GarageQueries{

        private $dbh;
        
        function startConnection(){
            $user = 'root';
            $pass = 'root';        
            try{
                $this->dbh = new PDO( 'mysql:host=localhost;dbname=tp_sql', $user, $pass);
                //echo("Connection OK");
            }
            catch(PDOException $ex){
                echo $ex->getMessage();
                die("Connection KO");
            }
        }

        function showGarage(){
            $sql = "SELECT * FROM garage";
            $query = $this->dbh->query($sql);
            $values = $query->fetchAll();
            foreach($values as $garages){
                echo '<p>';
                echo 'Name : '.' ';
                echo $garages['name'].' <br>';                    
                echo 'City : '.' ';
                echo $garages['city'].' <br>';
                echo'<a href="garage_car.php?garage_id='.$garages['ID'].'">Afficher les voitures de ce garage </a>';
                echo'<br><a href="./garage_delete.php?garage_id='.$garages['ID'].'">Supprimer ce garage </a>';
            }
            echo'<br><br><a href="./garage_add.php">Ajouter garage</a><br><br>';
        }

        function showCar($id){
            $sql = "SELECT * FROM car WHERE garage_id = $id  ";
            $query = $this->dbh->query($sql);
            $values = $query->fetchAll();
            foreach($values as $car){
                echo '<p>';
                echo ' Model: '.' ';
                echo $car['model'].' ';                    
                echo 'Color : '.' ';
                echo $car['color'].' ';
                echo 'Price : '.' ';
                echo $car['price'].' ';
                echo 'Garage ID : '.' ';
                echo $car['garage_id'].' ';
                echo '</p>';
            }
        }

        function garageForm($new_garage){
            $sql = "INSERT INTO garage (name, city, birthdate, annual_turnover) VALUES (:name, :city, :birthdate, :annual_turnover)";
            $stmt = $this->dbh->prepare($sql);
            $succeed = $stmt->execute($new_garage);
            if ($succeed == true){
                header('Location:garage.php?alert=added');
            }
            return $succeed;
        }

        function deleteGarage($id){
            $sql = 'DELETE FROM garage WHERE id ='.$id;
            
            $stmt = $this->dbh->prepare($sql);
            $succeed = $stmt->execute();
            if ($succeed){
                header('Location:garage.php?alert=deleted');
            }
            return $succeed;
            
        }
    }
?>