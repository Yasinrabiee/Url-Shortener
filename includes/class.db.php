<?php
// require_once '../config.php';
class DB
{
    public static function connect()
    {
        try{
            return new PDO(
                    "mysql:host="._DBHOST.";dbname="._DBNAME.";charset=utf8mb4;",
                    _DBUNAME,
                    _DBPASS,
                    []
                );
        }
        catch(PDOException $e){
            pre($e);
            return 0;
        }
    }

    /*
    $params = [];
    $params['table'] = 'test';
    $params['fields'] = 
        [
            'test'=>$test,
        ];
    DB::insert($params);
    */
    public static function insert(&$params)
    {
        global $link;
        $table = $params['table'];
        $fields = $params['fields'];
        $prefix = $params['prefix'] ?? _PREFIX;

        $fieldsKeys = array_keys($fields);
        $fieldsValues = [];

        foreach ($fieldsKeys as $key) 
            $fieldsValues[] = ":".$key;

        $q="INSERT INTO ".$prefix.$table."
            (".implode(",", $fieldsKeys).")
        VALUES 
            (".implode(",", $fieldsValues).")
        ";
        $query = $link->prepare($q);

        foreach ($fields as $key => $value) 
        {
            if($value==="")
                $value=null;

            $query->bindValue(":".$key,$value);
        }

        
        try{
            $query->execute();
        }
        catch(Exception $e){
            if(_DEV==1)
                DB::dev($params,$query,$q,getBoundQuery($q,$params['fields']));
        }
        if(_DEV==2)
            DB::dev($params,$query,$q,getBoundQuery($q,$params['fields']));

        $counts = $query->rowCount();
        if($counts!=0)
            return $link->lastInsertId();
        $res=$query->errorInfo();
        $_SESSION['errorCode'] = $res[2];
        return 0;
    }

    /*
    $params = [];
    $params['table'] = 'post';
    $params['where'] = "id=:id";
    $params['fields'] = ['id'=>post['id'],'views'=>post['views']+1];
    DB::update($params);
    */
    public static function update(&$params)
    {
        global $link;
        if(!isset($params['where']) || empty($params['where']))
            return false;
        $table = $params['table'];
        $fields = $params['fields'];
        $where = 'where '.$params['where'];
        $prefix = $params['prefix'] ?? _PREFIX;

        $fieldsKeys = array_keys($fields);
        $setValues ="";
        $c = 0;
        $arrayCount = count($fieldsKeys);
        foreach ($fieldsKeys as $key)
        {
            $setValues.=$key."=:".$key.(($c==$arrayCount-1)?'':', ');
            $c++;
        }

        $q = "UPDATE ".$prefix.$table." SET $setValues $where";
        $q2 = '';
        $query = $link->prepare($q);

        foreach($fields as $key => $value) 
        {
            if($value==="")
                $value = null;

            $query->bindValue(":".$key,$value);
        }

        try{
            $query->execute();
        }
        catch(Exception $e){
            if(_DEV==1)
                DB::dev($params,$query,$q,getBoundQuery($q,$params['fields']));
        }
        if(_DEV==2)
            DB::dev($params,$query,$q,getBoundQuery($q,$params['fields']));

        // $counts = $query->rowCount();
        $res=$query->errorInfo();
        if($res[0]==0)
            return true;
        else
        {
            $_SESSION['errorCode'] = $res[2];
            return false;
        }
    }




    /*
    $params = [
        'table' => $do,
        'columns' => '*',
        'where' => $where,
        'whereArray' => $whereArray,
        'order' => 'order by '.$order.' '.$sort,
        'limit' => ' limit '.($start*$limit).','.$limit
    ];
    e.g:
    $params = [
        'table' => 'post',
        'columns' => '*',
        'where' => 'title like :title or summary like :summary or body like :body',
        'whereArray' => ['title'=>"%$q%",'summary'=>"%$q%",'body'=>"%$q%"],
        'order' => 'order by id desc'
    ];
    DB::select($params);
    */
    public static function select(&$params)
    {
        global $link;
        $prefix = $params['prefix'] ?? _PREFIX;
        // to support INNER JOIN
        $table = str_replace('prfx_',$prefix,$params['table']);
        $columns = $params['columns'] ?? '*';
        $columns = str_replace('prfx_',$prefix,$columns);
        $where = $params['where'] ?? '';
        if(!empty($where) && strpos($where,'where')===false)
            $where = 'where '.$where;
        $where = str_replace('prfx_',$prefix,$where);
        $whereArray = $params['whereArray'] ?? [];
        $order = $params['order'] ?? '';
        if(!empty($order) && strpos($order,'order by')===false)
            $order = 'order by '.$order;
        $limit = $params['limit'] ?? '';
        if(!empty($limit) && strpos($limit,'limit')===false)
            $limit = 'limit '.$limit;
        $count = $params['count'] ?? false;
        $flat = $params['flat'] ?? false;
        $returnQ = $params['returnQ'] ?? false;

        $q = "SELECT $columns FROM ".$prefix.$table." $where $order $limit";
        if($returnQ)
            return getBoundQuery($q,$whereArray);
        $query = $link->prepare($q);

        foreach($whereArray as $key => $value) 
        {
            $query->bindValue(":".$key,$value);
        }

        try{
            $query->execute();
        }
        catch(Exception $e){
            if(_DEV==1)
                DB::dev($params,$query,$q,getBoundQuery($q,$whereArray));
            return array();
        }
        if(_DEV==2)
            DB::dev($params,$query,$q,getBoundQuery($q,$whereArray));

        if($count==true)
            return $query->rowCount();

        if($flat==true)
            return $query->fetchAll(PDO::FETCH_COLUMN, 0);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    $params = [];
    $params['table'] = 'test';
    $params['column'] = 'id';
    $params['ids'] = [1,2];
    DB::delete($params);
    */
    public static function delete(&$params)
    {
        global $link;
        $table = $params['table'];
        $ids = $params['ids'];
        $column = $params['column'];
        $prefix = $params['prefix'] ?? _PREFIX;

        $q = "DELETE FROM ".$prefix.$table." WHERE $column IN(".implode(",", $ids).")";
        $query = $link->prepare($q);

        try{
            $query->execute();
        }
        catch(Exception $e){
            if(_DEV==1)
                DB::dev($params,$query,$q,$e);
            return 0;
        }
        if(_DEV==2)
            DB::dev($params,$query,$q,$e);

        $counts = $query->rowCount();
        return $counts;
    }

    public static function dev(&$params,&$query,&$q,$extra)
    {
        pre($params);
        pre($q);
        if($query)
        {
          pre($query->errorInfo());
          pre($query->debugDumpParams());
        }
        pre($extra);
    }
}


function pre($value='')
{
    echo '<pre style="direction: ltr; text-align: left">';
    if(is_array($value))
        print_r($value);
    else
        echo $value;
    echo '</pre>';
}

function getBoundQuery($q,$fields)
{
    foreach($fields as $key => $value)
    {
        $q = str_replace(":".$key,"'".$value."'",$q);
    }
    return $q;
}
?>