<?php
namespace model;


use db\DB;

class Message
{
    public static $COL_ID = "id";
    public static $COL_ID_EXPEDITEUR = "id_expediteur";
    public static $COL_ID_DESTINATAIRE = "id_destinataire";
    public static $COL_MESSAGE = "message";
    public static $COL_SUJET = "sujet";
    public static $COL_DATE = "date";
    public static $COL_STATUT = "statut";

    public static $TABLE = "message";

    public static $VU = 1;
    public static $PAS_VU = 0;

    public $id;
    public $id_expediteur;
    public $id_destinataire;
    public $message;
    public $sujet;
    public $date;
    public $statut;

    /**
     * Message constructor.
     * @param $id
     * @param $id_expediteur
     * @param $id_destinataire
     * @param $message
     * @param $sujet
     * @param $date
     * @param $statut
     */
    public function __construct($id, $id_expediteur, $id_destinataire, $message, $sujet, $date, $statut)
    {
        $this->id = $id;
        $this->id_expediteur = $id_expediteur;
        $this->id_destinataire = $id_destinataire;
        $this->message = $message;
        $this->sujet = $sujet;
        $this->date = $date;
        $this->statut = $statut;
    }


    public static function find($id) {
        $result = DB::find(Message::$TABLE,$id);
        return $result?
            new Message(
                $result[Message::$COL_ID],
                $result[Message::$COL_ID_EXPEDITEUR],
                $result[Message::$COL_ID_DESTINATAIRE],
                $result[Message::$COL_MESSAGE],
                $result[Message::$COL_SUJET],
                $result[Message::$COL_DATE],
                $result[Message::$COL_STATUT]
            ):
            null;
    }

    public function expediteur() {
        return Utilisateur::find($this->id_expediteur);
    }

    public function destinateur() {
        return Utilisateur::find($this->id_destinataire);
    }

    public static function lastId() {
        return DB::lastId(Message::$TABLE);
    }

    public function delete() {
        DB::getDB()->query('DELETE FROM '.Message::$TABLE.' WHERE '.Message::$COL_ID.'='.$this->id);
    }

    public function update($message,$sujet){
        DB::getDB()->query('UPDATE '.Message::$TABLE.' SET '
            .Message::$COL_MESSAGE.'="'.$message.'", '
            .Message::$COL_SUJET.'="'.$sujet.'", '
            .Message::$COL_DATE.'=now(), '
            .' WHERE '.Message::$COL_ID.'='.$this->id
        ) ;
    }

    public function updateVu() {
        DB::getDB()->query('UPDATE '.Message::$TABLE.' SET statut = 1 WHERE '.Message::$COL_ID.'='.$this->id);
    }

    public static function create($id_expediteur,$id_destinataire,$message,$sujet) {
        $query = 'INSERT INTO '.Message::$TABLE.'('.Message::$COL_ID_EXPEDITEUR.','.Message::$COL_ID_DESTINATAIRE.','.Message::$COL_MESSAGE.','.Message::$COL_SUJET.','.Message::$COL_DATE.','.Message::$COL_STATUT.') VALUES '
        .'( :sender,:target,:message,:topic,datetime("now"),'.Message::$PAS_VU.')';
        $stm = DB::getDB()->prepare($query);
        $stm->bindValue(':sender',$id_expediteur);
        $stm->bindValue(':target',$id_destinataire);
        $stm->bindValue(':message',$message);
        $stm->bindValue(':topic',$sujet);
        $stm->execute();
    }


}
