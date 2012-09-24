<?php
/**
 * Класс обеспечивает контроль структуры базы данных
 */

class FSDBSS {
    protected $arDBStructure;
    private $arColumnTypes;     /**<Массив со списком доступных типов полей*/
    protected $sTableType;      /**<Тип создаваемых таблиц*/
    protected $obDB;

    /**
     * Конструктор класса.
     * @param $debug - устанавливает уровень отладки
     * @since 1.2
     * @author blade39 <blade39@kolosstudio.ru>
     */
    function __construct() {
        $this->arColumnTypes=array('char','varchar','int','float','text','enum');
        $this->sTableType='MyISAM';
        $this->obDB=Yii::app()->getDb();
    }

    /**
     * Метод выполняющий анализ и сравнение структуры базы данных
     * со структурой переданной в виде ассоциативного массива
     * в качестве параметра
     * @param $arDBStructure - массив описывающий структуру базы данных
     */
    public function CheckDB($arDBStructure) {
        if(!is_array($arDBStructure) || count($arDBStructure)==0) return false;
        $this->arDBStructure=$this->ListTables(true);
        foreach($arDBStructure as $sTableName=>$arTableStructure)
            if(array_key_exists($sTableName,$this->arDBStructure))
                $this->CheckTable($sTableName,$arTableStructure);
            else
                $this->AddTable($sTableName,$arTableStructure);
    }

    /**
     * Метод осуществляет анализ таблицы
     * @param $sTable - имя таблицы которую надо проанализировать
     * @param $arTableStructure - структура массива описывающая таблицу
     */
    public function CheckTable($sTable,$arTableStructure) {
        if(!is_array($this->arDBStructure))
            $this->arDBStructure=$this->ListTables(true);
        if(!array_key_exists($sTable,$this->arDBStructure))
            throw new CDbException('TABLE_NOT_FOUND');
        else {
            foreach($arTableStructure as $sField=>$arField) {
                if(array_key_exists($sField,$this->arDBStructure[$sTable])) {
                    //Если поле таблице существует, надо проверить его параметры
                    $bUpdate=false;
                    $arField=$this->_fillFieldStruct($arField);
                    foreach($arField as $sParam=>$sValue) {
                        if($sParam=='Default' && $arField['Key']=='PRI')
                            continue;
                        if($sParam=='Extra' && $sValue=='fulltext') {
                            if($this->arDBStructure[$sTable][$sField]['Key']=='MUL')
                                continue;
                            else {
                                $bUpdate=true;
                                break;
                            }
                        }
                        if($this->arDBStructure[$sTable][$sField][$sParam]!=$sValue) {
                            $bUpdate=true;
                            break;
                        }
                    }
                    if($bUpdate)
                        $this->UpdateColumn($sTable,$sField,$arField);
                } else {
                    //Поле таблицы не существует, надо создать
                    $this->AddColumn($sTable,$arField);
                }
            }
        }
    }

    /**
     * Метод возвращает список таблиц текущей базы данных
     */
    public function ListTables($bGetFields=false) {
        $arDB=$this->obDB->getTableNames();
        if($bGetFields) {
            $arResult=array();
            foreach($arDB as $table) {
                $obTable=$this->obDB->loadTable($table);
                foreach($obTable->columns as $obColumn) {
                    $arResult[$table]=array(
                        'Field' =>  $obColumn->name,
                        'Type'  =>  $obColumn->dbType,
                        'Null'  =>  $obColumn->allowNull?'':'NO',
                        'Key'   =>  $obColumn->isPrimaryKey?'PRI':'',
                        'Default'=> $obColumn->defaultValue,
                        'Extra' =>  $obColumn->autoIncrement?'auto_increment':''
                    );
                }
            }
        } else
            $arResult=$arDB;
        return $arResult;
    }

    /**
     * Метод опрашивает таблицу, и получает список её полей.
     * @param $sTable таблица для которой надо получить поля
     * @param $sPrefix префикс названия полей которые надо получить
     */
    public function GetTableFields($sTable,$sPrefix='') {
        $obTable=$this->obDB->loadTable($sTable);
        $arResult=array();
        foreach($obTable->columns as $obColumn) {
            if($sPrefix!=''&& !preg_match('#^'.$sPrefix.'#i',$obColumn->name)) continue;    
            $arResult[$table]=array(
                'Field' =>  $obColumn->name,
                'Type'  =>  $obColumn->dbType,
                'Null'  =>  $obColumn->allowNull?'':'NO',
                'Key'   =>  $obColumn->isPrimaryKey?'PRI':'',
                'Default'=> $obColumn->defaultValue,
                'Extra' =>  $obColumn->autoIncrement?'auto_increment':''
            );
        }
        return $arResult;
    }
    
    /**
     * Функция заполняет массив описывающий структуру поля, на случай отсутствия полей
     * @param $fields - массив описания поля или имя поля
     */
    private function _fillFieldStruct($field) {
        if(is_string($field))
            $field=array('Field'=>$field);
        if(!isset($field['Extra'])) $field['Extra']='';
        if(!isset($field['Default'])) $field['Default']='';
        if(!isset($field['Null'])) $field['Null']='NO';
        if(!isset($field['Key'])) $field['Key']='';
        if(!isset($field['Type'])) $field['Type']='char(255)';
        return $field;
    }

    /**
     * Метод выполняет добавление таблицы в базу данных mysql
     */
    public function AddTable($sTable,$arTableStructure) {
        if(!is_array($arTableStructure)) return false;
        $arFields=array();
        $arFullText=array();
        $sOptions='';
        foreach($arTableStructure as $sField=>$arFieldParams) {
            $arFieldParams=$this->_fillFieldStruct($arFieldParams);
            $arFields[$sField]=$arFields['Type'].' '.
                ($arFieldParams['Null']=='NO'?'NOT NULL':'NULL');
            if($arFieldParams['Extra']!='auto_increment') {
                if($arFieldParams['Type']!='date')
                    $arFields[$sField].=($arFieldParams['Default']!=''?" DEFAULT '".$arFieldParams['Default']."' ":" DEFAULT ''");
            } else
                $arFields[$sField].=$arFieldParams['Extra'];
            $arFields[$sField].=($arFieldParams['Key']=='PRI'?' PRIMARY KEY':'');
            if($arFieldParams['Extra']=='fulltext')
                $arFullText[]=$arFieldParams['Field'];
        }
        if(count($arFullText)>0)
            $sOptions=' FULLTEXT INDEX ('.join(',',$arFullText).')';
        $this->obDB->createCommand()->createTable($sTable,$arFields,$sOptions);
    }

    /**
     * Метод выполняет добавление колонки в таблицу
     * Внимание метод изменен! В качестве параметра колнки допускается
     * передавать только строку или массив в формате возвращаемом
     * при анализе таблицы mysql
     */
    public function AddColumn($sTable,$arColumn) {
        //Если передали число - выходим
        if(is_numeric($arColumn)) return false;
        $arColumn=$this->_fillFieldStruct($arColumn);
        $sType=$arColumn['Type'].' '.
            ($arColumn['Null']=='NO'?'NOT NULL':'NULL').' ';
        if($arColumn['Extra']!='auto_increment') {
            if($arColumn['Type']!='date')
                $sType.=($arColumn['Default']!=''?" DEFAULT '".$arColumn['Default']."' ":" DEFAULT ''");
        } else
            $sType.=$arColumn['Extra'];
        if($arColumn['Key']=='PRI')
            $sType.=' PRIMARY KEY';
        $this->obDB->createCommand()->addColumn($sTable,$arColumn['Field'],$sType);
        ///TODO Необходимо доделать в будущей версии для получения полного функционала 
        /*if($arColumn['Extra']=='fulltext') {
            $query="ALTER TABLE ".PREFIX.$sTable.' ADD FULLTEXT ('.$arColumn['Field'].')';
            $this->query($query);
        }
        if($arColumn['Key']=='UNI') {
            $query="ALTER TABLE ".PREFIX.$sTable.' ADD UNIQUE ('.$arColumn['Field'].')';
            $this->query($query);
        }*/
        return true;
    }

    /**
     * Метод выполняет обновление типа данных указанного поля
     */
    public function UpdateColumnType($sTable,$sColumn,$sType) {
        //Если передали число - выходим
        if(is_numeric($sType)) return false;
        //Если передали строку создаем поле по умолчанию
        $arColumn=$this->DescribeColumn($sTable,$sColumn);
        if(!$arColumn) return false;
        if($arColumn['Type']==$sType) return false;
        if(strpos($sType,'int')!==false || strpos($sType,'float')!==false)
            $arColumn['Default']="0";
        if($sType=='text') $arColumn['Default']='';
        if($sType!='date')
            $this->obDB->createCommand()->alterColumn($sTable,$sColumn,$sType.($arColumn['Null']=='NO'?'NOT NULL':'NULL')." default '".$arColumn['Default']."'");
        else
            $this->obDB->createCommand()->alterColumn($sTable,$sColumn,$sType.($arColumn['Null']=='NO'?'NOT NULL':'NULL'));
        return true;
    }

    /**
     * Метод выполняет обновление колонки указанной таблицы
     */
    public function UpdateColumn($sTable,$sColumn,$arFieldParams) {
        //Если передали строку создаем поле по умолчанию
        $arFieldParams=$this->_fillFieldStructure($arFieldParams);
        $arColumn=$this->DescribeColumn($sTable,$sColumn);
        if($arColumn['Key']=='UNI')
            //Есть ключ уникальности колонки
            if($arFieldParams['Key']!=$arColumn['Key'])
                $this->obDB->createCommand()->dropIndex($sTable,$sColumn);
        $sType=$arFieldParams['Field'].'` '.
            $arFieldParams['Type'].' '.
            ($arFieldParams['Null']=='NO'?'NOT NULL':'NULL').' ';
        if($arFieldParams['Extra']!='auto_increment') {
            if($arFieldParams['Type']!='date')
                $sType.=($arFieldParams['Default']!=''?" DEFAULT '".$arFieldParams['Default']."' ":" DEFAULT ''");
        }
        else
            $sType.=$arFieldParams['Extra'];
        $this->obDB->createCommand()->alterColumn($sTable,$sColumn,$sType);
        ///TODO Необходимо доделать в будущей версии для получения полного функционала 
        /*if($arFieldParams['Extra']=='fulltext') {
            $query="ALTER TABLE ".PREFIX.$sTable.' ADD FULLTEXT ('.$arFieldParams['Field'].')';
            $this->query($query);
        }
        if($arFieldParams['Key']=='UNI') {
            $query="ALTER TABLE ".PREFIX.$sTable.' ADD UNIQUE ('.$arFieldParams['Field'].')';
            $this->query($query);
        }*/
        return true;
    }

    /**
     * Метод выполняет получение информации о колонке таблицы
     */
    protected function DescribeColumn($sTable,$sColumn) {
        $obTable=$this->obDB->getSchema()->getTable($sTable,true);
        if($obColumn=$obTable->getColumn($sColumn)) {
            $arResult=array(
                'Field' =>  $obColumn->name,
                'Type'  =>  $obColumn->dbType,
                'Null'  =>  $obColumn->allowNull?'':'NO',
                'Key'   =>  $obColumn->isPrimaryKey?'PRI':'',
                'Default'=> $obColumn->defaultValue,
                'Extra' =>  $obColumn->autoIncrement?'auto_increment':''
            );
            return $arResult;
        } else {
            return false;
        }
    }

    /**
     * Метод выполняет удаление таблицы или таблиц переданных методу
     * @param $arTables mixed - список или одна таблица которые требуется удалить
     */
    public function DeleteTables($arTables) {
        if(!is_array($arTables)) $arTables=array($arTables);
        $arDBTables=$this->ListTables();
        $arTablesToDelete=array();
        foreach($arTables as $sTable)
            if(in_array($sTable,$arDBTables))
                $this->obDB->getSchema()->dropTable($sTable);
    }

    /**
     * Метод выполняет удаление колонки из таблицы
     * @param $sTable
     * @param $sColumn
     */
    public function DeleteColumn($sTable,$sColumn) {
        $this->obDB->createCommand()->dropColumn($sTable,$sColumn);
    }

    /**
     * Метод выполняет переименование одной таблицы в другую
     * @param $sTable
     * @param $sNewName
     */
    public function RenameTable($sTable,$sNewName) {
        $this->obDB->createCommand()->renameTable($sTable,$sNewName);
    }
} 
 