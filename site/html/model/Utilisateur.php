<?php
namespace model;


use db\DB;
use SQLite3;

class Utilisateur
{
    public static $COL_ID = "id";
    public static $COL_PSEUDO = "pseudo";
    public static $COL_PASSWORD = "password";
    public static $COL_TYPE = "Type";
    public static $COL_ACTIF = "actif";

    public static $TABLE = "utilisateur";

    public static $ADMINISTRATOR = 1;
    public static $COLLABORATOR = 0;

    public static $ACTIF = 1;
    public static $NON_ACTIF = 0;

    public $id;
    public $pseudo;
    public $password;
    public $type;
    public $actif;

    /**
     * Message constructor.
     * @param $id
     * @param $type
     * @param $actif
     */
    public function __construct($id,$pseudo,$password, $type, $actif)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->password = $password;
        $this->type = $type;
        $this->actif = $actif;
    }

    public function update($pseudo,$password,$type,$actif) {
        if($password == ""){
            $stm = DB::getDB()->prepare('UPDATE '.Utilisateur::$TABLE.' SET '
            .Utilisateur::$COL_PSEUDO.'= :pseudo, '
            .Utilisateur::$COL_TYPE.'= :type, '
            .Utilisateur::$COL_ACTIF.'= :actif'.
            ' WHERE '.Utilisateur::$COL_ID.'='.$this->id
            ) ;
        }else{
            $hash = password_hash($password,\PASSWORD_BCRYPT);
            $stm = DB::getDB()->prepare('UPDATE '.Utilisateur::$TABLE.' SET '
            .Utilisateur::$COL_PSEUDO.'= :pseudo, '
            .Utilisateur::$COL_PASSWORD.'= :hash , '
            .Utilisateur::$COL_TYPE.'= :type, '
            .Utilisateur::$COL_ACTIF.'= :actif'.
            ' WHERE '.Utilisateur::$COL_ID.'='.$this->id
            ) ;
            $stm->bindValue(':hash',$hash);
        }
        $stm->bindValue(':pseudo',$pseudo);
        $stm->bindValue(':type',$type);
        $stm->bindValue(':actif',$actif);
        $stm->execute();
    }

    public static function create($pseudo,$password,$type,$actif) {

        $stm = DB::getDB()->prepare('INSERT INTO '.Utilisateur::$TABLE.'('.Utilisateur::$COL_PSEUDO.','.Utilisateur::$COL_PASSWORD.','.Utilisateur::$COL_TYPE.','.Utilisateur::$COL_ACTIF.') VALUES '
        .'(:pseudo,:hash,:type,:actif)');
        $hash = password_hash($password,\PASSWORD_BCRYPT);
        $stm->bindValue(':pseudo',$pseudo);
        $stm->bindValue(':hash',$hash);
        $stm->bindValue(':type',$type);
        $stm->bindValue(':actif',$actif);
        $stm->execute();
       
    }


    public function desactiver() {
        //$this->update($this->pseudo,$this->password,$this->type,Utilisateur::$NON_ACTIF);
        DB::getDB()->query('DELETE FROM '.Message::$TABLE.' WHERE '.Message::$COL_ID_EXPEDITEUR.' = '.$this->id.' OR '.Message::$COL_ID_DESTINATAIRE.' = '.$this->id);
        DB::getDB()->query('DELETE FROM '.Utilisateur::$TABLE.' WHERE '.Utilisateur::$COL_ID.' = '.$this->id);
    }
    public function activer() {
        $this->update($this->pseudo,$this->password,$this->type,Utilisateur::$ACTIF);
    }

    public function isAdministrator() {
        return $this == Utilisateur::$ADMINISTRATOR;
    }

    public function isCollaborator() {
        return $this == Utilisateur::$COLLABORATOR;
    }

    public function messages() {
        $resultat = DB::getDB()->query('SELECT * FROM '.Message::$TABLE.' WHERE '.Message::$COL_ID_DESTINATAIRE.'='.$this->id.' ORDER BY '.Message::$COL_DATE.' DESC');
        $messages = array();
        while ($result = $resultat->fetch())
            $messages[] = new Message(
                $result[Message::$COL_ID],
                $result[Message::$COL_ID_EXPEDITEUR],
                $result[Message::$COL_ID_DESTINATAIRE],
                $result[Message::$COL_MESSAGE],
                $result[Message::$COL_SUJET],
                $result[Message::$COL_DATE],
                $result[Message::$COL_STATUT]
            );
        return $messages;
    }

    public function sentmessages() {
        $resultat = DB::getDB()->query('SELECT * FROM '.Message::$TABLE.' WHERE '.Message::$COL_ID_EXPEDITEUR.'='.$this->id.' ORDER BY '.Message::$COL_DATE.' DESC');
        $messages = array();
        while ($result = $resultat->fetch())
            $messages[] = new Message(
                $result[Message::$COL_ID],
                $result[Message::$COL_ID_EXPEDITEUR],
                $result[Message::$COL_ID_DESTINATAIRE],
                $result[Message::$COL_MESSAGE],
                $result[Message::$COL_SUJET],
                $result[Message::$COL_DATE],
                $result[Message::$COL_STATUT]
            );
        return $messages;
    }

    public function messagesWith($user_id) {
        $data = DB::getDB()->query('SELECT * FROM '.Message::$TABLE.' WHERE ('.Message::$COL_ID_EXPEDITEUR.'='.$user_id.' AND '.Message::$COL_ID_DESTINATAIRE.'='.$this->id.') OR ('.Message::$COL_ID_EXPEDITEUR.'='.$this->id.' AND '.Message::$COL_ID_DESTINATAIRE.'='.$user_id.') ORDER BY '.Message::$COL_DATE.' DESC' );
        $messages = array();
        while ($result =$data->fetch())
            $messages[] = new Message(
                $result[Message::$COL_ID],
                $result[Message::$COL_ID_EXPEDITEUR],
                $result[Message::$COL_ID_DESTINATAIRE],
                $result[Message::$COL_MESSAGE],
                $result[Message::$COL_SUJET],
                $result[Message::$COL_DATE],
                $result[Message::$COL_STATUT]
            );
        return $messages;
    }

    public static function find($id) {
        $result = DB::find(Utilisateur::$TABLE,$id);
        return $result?
            new Utilisateur(
                $result[Utilisateur::$COL_ID],
                $result[Utilisateur::$COL_PSEUDO],
                $result[Utilisateur::$COL_PASSWORD],
                $result[Utilisateur::$COL_TYPE],
                $result[Utilisateur::$COL_ACTIF]
            ):
            null;
    }

    public static function all() {
        $all = array();
        $data = DB::getDB()->query("SELECT * FROM ".Utilisateur::$TABLE);
        while($result = $data->fetch()) {
            $all[] = new Utilisateur(
                $result[Utilisateur::$COL_ID],
                $result[Utilisateur::$COL_PSEUDO],
                $result[Utilisateur::$COL_PASSWORD],
                $result[Utilisateur::$COL_TYPE],
                $result[Utilisateur::$COL_ACTIF]
            );
        }
        return $all;
    }

    public static function lastId() {
        return DB::lastId(Utilisateur::$TABLE);
    }

    public function isExpediteurOf(Message $message) {
        return $message->id_expediteur == $this->id;
    }

    public function isDestinataireOf(Message $message) {
        return $message->id_destinataire == $this->id;
    }


}
