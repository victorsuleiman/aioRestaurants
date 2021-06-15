<?php  

    //Mongo Includes
    use MongoDB\Driver\Manager;
    use MongoDB\Driver\Query;
    use MongoDB\Driver\Command;
    use MongoDB\Driver\BulkWrite;
    use MongoDB\Driver\Exception\Exception;

/*
Executar a query e setar a coleção
*/
    class PDOMongo{

        public static $errorLog = [];

        //Connection variables
        private static $mongoName = MONGO_DB_NAME;
        private static $mongoUser = MONGO_DB_USER;
        private static $mongoPass = MONGO_DB_PASS;
        private static $mongoHost = MONGO_DB_HOST;

        
        //MONGO URL CONNECTION
        private static $mongoUrl = DEFAULT_URL;

        //Counter
        private static $counter;

        //Validation variables
        private static $currentCollection = "";
        private static $collectionKeys = [];
        private static $collectionList = [];
        
        //Query variables
        private static $filter = [];
        private static $options = [];


        public function __construct($collection){
            self::defineMongoConnection();
            self::setCollectionList();
            self::setCollection($collection);
            self::setCounter();
        }

        public static function setCollection($collection = ""){
            self::$currentCollection = $collection;
            self::setCollectionKeys(self::$currentCollection);
        }

        private static function testConnection(){
            $valid = false;
            $mongoManager = new Manager(self::$mongoUrl);

            $ping = $mongoManager->executeCommand(
                self::$mongoName,
                new Command(["ping"=>1])
            );

            if($ping->toArray()[0]->ok == 1){
                $valid = true;
            }

            return $valid;
        }

        //Create and define the mongodb Connection
        #$login #$pass #$db and #$cluster
        private static function defineMongoConnection(){
            try{
                
                self::$mongoUrl = "mongodb+srv://";
                self::$mongoUrl .= self::$mongoUser.":".self::$mongoPass;
                self::$mongoUrl .= self::$mongoHost."/";
                self::$mongoUrl .= self::$mongoName."?retryWrites=true&w=majority";

                //Test connection with the MongoDB
                if(!self::testConnection()){
                    throw new Exception(
                        "There is no connection!\n
                    Please, check the connection settings."
                    );
                }

            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
                exit;
            }
            
        }

        private static function setCollectionList(){
            //Create a Command object
            //Commando Objects execute Atlas MongoDB functions
            //listCollection is a function from Atlas MongoDB. 1 means true
            $listDb = new Command(["listCollections" => 1]);

            $mongoManager = new Manager(self::$mongoUrl);
            //DB is the selected database and the $listDb runs the Atlas mongoDB command
            $result = $mongoManager->executeCommand(
                self::$mongoName,$listDb
            );
            
            //Assigns the result as an array into a variable
            $collections = $result->toArray();
            
            //Collects the name of each collection
            for($i = 0; $i < count($collections); $i++){
                self::$collectionList[] = $collections[$i]->name;
            }
        }

        private static function setCollectionKeys($nCollection){
            $query = new Query(
                [],
                ['sort'=>array('_id'=>1),'limit'=>1,'projection' => []]
            );

            $mongoManager = new Manager(self::$mongoUrl);

            $cursor = $mongoManager->executeQuery(
                self::$mongoName.".".$nCollection,$query
            );
            self::$collectionKeys = array_keys(
                get_object_vars($cursor->toArray()[0])
            );
        }

        //This method validates if exists the field/attribute
        //provided by the user
        private static function validateFields($key){
            $valid = false;

            if(is_string($key)){
                if(in_array($key,self::$collectionKeys)){
                    $valid = true;
                }
            }
            return $valid;
        }

        private static function setSortResult($keySort){
            try{

                if( !empty($keySort) ){

                    if(self::validateFields($keySort)){
                        self::$options["sort"] = array($keySort=>1);
                    } else {
                        throw new Exception("This is not a valid field to sort!");
                    }
                    
                } else if(empty($keySort)){
                    self::$options["sort"] = array("_id"=>1);

                }
            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
        }

        //This method will set the returned fields from the collection
        //Using this method will return selected fields from the collection
        private static function setQueryFields($elements){
            
            try{
                
                if(is_array($elements)){

                    if(!empty($elements)){

                        $projection = [];

                        for($i = 0; $i < count($elements); $i++){

                            if( self::validateFields($elements[$i]) ){

                                $projection[$elements[$i]] = 1;

                            } else {

                                $field = $elements[$i];
                                throw new Exception(
                                    "This $field Field does not exist!"
                                );

                            }
                            self::$options["projection"] = $projection;
                        }
                    }

                } else {
                    throw new Exception("This is not an array!");
                }
            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
        }

        //This method set the number of results 
        private static function setTotalResults($totalResults){
            try{
                if(is_integer($totalResults)){
                    self::$options["limit"] = $totalResults;
                } else {
                    throw new Exception("This is not a valid number!");
                }
            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
        }

        //This method will validate the user input data to find in the collection
        public static function bindElement($collectionField,$input){

            try{

                switch(gettype($input)){

                    case "string":
                        self::$filter[$collectionField] = $input;
                        break;
                    case "integer":
                        self::$filter[$collectionField] = $input;
                        break;
                    case "double":
                        self::$filter[$collectionField] = $input;
                        break;
                    case "boolean":
                        self::$filter[$collectionField] = $input;
                        break;
                    case "NULL":
                        self::$filter[$collectionField] = $input;
                        break;
                    default:
                        throw new Exception("This is not a valid input");
                        break;
                }
            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
        }

        //This method execute the query
        #collection is the name of the collection from the db
        #fields is an array of strings. Each string correponds to a collection field
        #limit limits the number of results from the database
        public function findData(
            $fields,
            $limit = 0, //Default 0 brings all the results
            $keySort = "_id"
        ){
            try{
                self::setSortResult($keySort);
                self::setQueryFields($fields);
                self::setTotalResults($limit);

                $query = new Query(self::$filter,self::$options);
                $mongoManager = new Manager(self::$mongoUrl);

                $cursor = $mongoManager->executeQuery(
                    self::$mongoName.".".self::$currentCollection,
                    $query
                );

                return $cursor->toArray();

            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
        }


        //Insert Data into MongoDb
        public function insertData(stdClass $newEntry){

            try{

                //Only insert into DB
                $bulk = new BulkWrite();
                $bulk->insert($newEntry);
                $mongoManager = new Manager(self::$mongoUrl);

                $cursorInsert = $mongoManager->executeBulkWrite(
                    self::$mongoName.".".self::$currentCollection,
                    $bulk
                );
                
                self::addCounter();
                return $cursorInsert->getInsertedCount();

                if(!self::testConnection()){
                    throw new Exception("This is not a valid type to insert.\n
                    The Element was not inserted\n
                    PDOMongoClass insertData()");
                }

            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
            
        }

        //Update Data from MongoDb
        public function updateData(stdClass $newEntry){
            try{
                $bulk = new BulkWrite();
                $bulk->update(
                    ["_id" => $newEntry->_id],
                    ['$set' => $newEntry],
                    ['multi' => false, 'upsert' => false]
                );

                $mongoManager = new Manager(self::$mongoUrl);

                $cursorInsert = $mongoManager->executeBulkWrite(
                    self::$mongoName.".".self::$currentCollection,
                    $bulk
                );

                return $cursorInsert->getInsertedCount();

                if( !self::testConnection() ){
                    throw new Exception("This is not a valid type to insert.\n
                    The Element was not inserted\n
                    PDOMongo updateData()");  
                } 
            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
            
        }

        //Delete Data from MongoDb
        public function deleteData(stdClass $newEntry){
            try{
                $bulk = new BulkWrite();
                $bulk->delete(
                    ["_id" => $newEntry->_id],
                    ['limit' => 1]
                );

                $mongoManager = new Manager(self::$mongoUrl);

                $cursorInsert = $mongoManager->executeBulkWrite(
                    self::$mongoName.".".self::$currentCollection,
                    $bulk
                );

                return $cursorInsert->getInsertedCount();

                if( !self::testConnection() ){
                    throw new Exception("This is not a valid type to insert.\n
                    The Element was not inserted\n
                    PDOMongo deleteData()");
                    
                }
            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
            
        }

        private static function setCounter(){
            $mongoManager = new Manager(self::$mongoUrl);

            $query = new Query([]);
            $cursor = $mongoManager->executeQuery(
                self::$mongoName.".counter",
                $query
            );
            self::$counter = $cursor->toArray()[0];  
        }

        public function getCounter(){

            $autoIncrementId = json_decode(
                json_encode(
                    self::$counter
                ),true
            )[self::$currentCollection];
            $autoIncrementId++;
            return $autoIncrementId;
        }

        private static function addCounter(){
            $newEntry = json_decode(
                json_encode(
                    self::$counter
                ),true
            );
            
            $newId = $newEntry[self::$currentCollection];
            $newId++;


            $bulkCounter = new BulkWrite();
            $bulkCounter->update(
                [self::$currentCollection => $newEntry[self::$currentCollection]],
                ['$set' => 
                    [
                        self::$currentCollection => $newId
                    ]
                ],
                ['multi' => false, 'upsert' => false]
            );

            $mongoManagerCounter = new Manager(self::$mongoUrl);

            $cursorCounter = $mongoManagerCounter->executeBulkWrite(
                self::$mongoName.".counter",
                $bulkCounter
            );

            return $cursorCounter->getInsertedCount();

        }
    }