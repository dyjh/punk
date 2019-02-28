<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/17 0017
 * Time: 下午 4:11
 */

namespace Think;


class Xmlreader{
        
//     <xml>
//         <persons count="10">
//             <person username="username1" age="20">this is username1 description</person>
//             <person username="username2" age="20">this is username2 description</person>
//         </persons>
//     </xml>
    
    /**
     * 解析返回的XML文档
     */
    public function parseXmlFile($xmlFile){
        $reader = new \XMLReader();
        $reader->open($xmlFile, 'UTF-8');
        $nodeName = '';
        $dataList = array();
        $data = array();
        while ($reader->read()){
            if($reader->nodeType == \XMLReader::ELEMENT){
                $nodeName = $reader->name;
                if($nodeName=='persons'){
                    $count = $reader->getAttribute('count');
                    if(!($count>0)){
                        break;
                    }
                }
                elseif($nodeName=='person'){
                    $data = array(
                        'username'=>$reader->getAttribute('username'),
                        'age'=>$reader->getAttribute('age'),
                    );
                }
            }
            if($reader->nodeType == \XMLReader::TEXT && !empty($nodeName)){
                if($nodeName=='person'){
                    $data['description'] = strtolower($reader->value);
                    $dataList[] = $data;
                }
            }
        }
        $reader->close();
        return $dataList;
    }
    
    /**
     * 解析返回的XML文档
     */
    public function parseXmlStr($xmlString){
        $reader = new \XMLReader();
        $reader->xml($xmlString,'UTF-8');
        $nodeName = '';
        $dataList = array();
        $data = array();
        while ($reader->read()){
            if($reader->nodeType == \XMLReader::ELEMENT){
                $nodeName = $reader->name;
                if($nodeName=='persons'){
                    $count = $reader->getAttribute('count');
                    if(!($count>0)){
                        break;
                    }
                }
                elseif($nodeName=='person'){
                    $data = array(
                        'username'=>$reader->getAttribute('username'),
                        'age'=>$reader->getAttribute('age'),
                    );
                }
            }
            if($reader->nodeType == \XMLReader::TEXT && !empty($nodeName)){
                if($nodeName=='person'){
                    $data['description'] = strtolower($reader->value);
                    $dataList[] = $data;
                }
            }
        }
        return $dataList;
    }
}