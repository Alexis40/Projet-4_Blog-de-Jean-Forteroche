<?php

class ChapterManager extends Model{

    /*Permet de récuperer les données par chapitre pour affichage sur la page Home, ne selectionne que les 3 derniers chapitres et les tries 
    par ordre decroisssant du chapitreNumber.*/
    public function getChapters(){
        $sql = ('SELECT * FROM chapter ORDER BY chapterNumber DESC LIMIT 3');
        $chaptersList = [];
        $statement = $this->executeQuery($sql);
        while($rs = $statement->fetch()){
            $chapter = new Chapter($rs);
            $chaptersList[]= $chapter;
        }
        return $chaptersList;
    }

    public function getAllChapters(){
        $sql = ('SELECT * FROM chapter ORDER BY chapterNumber');
        $allChaptersList = [];
        $statement = $this->executeQuery($sql);
        while($rs = $statement->fetch()){
            $chapter = new Chapter($rs);
            $allChaptersList[]= $chapter;
        }
        return $allChaptersList;
    }

    public function getAllChapterWithID(){
        $sql = ('SELECT * FROM chapter ORDER BY chapterNumber');
        $allChaptersList = [];
        $statement = $this->executeQuery($sql);
        while($rs = $statement->fetch()){
            $chapter = new Chapter($rs);
            $allChaptersList[$chapter->getId()]= $chapter;
        }
        return $allChaptersList;
    }

    /*Permet de récuperer un chapitre donc on connais l'id*/
    public function getChapter($id){
        $sql = ('SELECT * FROM chapter WHERE id=?');
        $args = array($id);
        $statement = $this->prepareQuery($sql, $args);
        $rs = $statement->fetch();
        if($rs!=null){
            $chapter = new Chapter($rs);
            return $chapter;
        }
        return null;
    }

    /*Permet de récuperer le chapitre qui à le dernier id dans la table.*/
    public function getLastIdChapter(){
        $sql = ('SELECT MAX(id) AS max_id FROM chapter');
        $statement = $this->executeQuery($sql);
        $rs = $statement->fetch();

        return $rs['max_id'];
    }

    /*REQUÈTE PERMETTANT DE PASSER LE CHAMP REPORT (QUI EST INITIALEMENT DEFINI A 0) A 1 */
    public function changeReport($reportId){
        $sql = ('UPDATE comments SET report=1 WHERE id=?');
        $args = array($reportId);
        return $this->prepareQuery($sql, $args);
    }

    /*REQUÈTE PERMETTANT D'AJOUTER UN CHAPITRE A LA BASE DANS LA TABLE CHAPTER*/
    public function addChapter($addChapter){
        $sql = ('INSERT INTO chapter(chapterNumber, chapterName, ChapterContent, dateOfPublication)VALUES(?,?,?,NOW())');
        $args = array($addChapter->getChapterNumber(),$addChapter->getChapterName(),$addChapter->getAllChapterContent());
        return $this->prepareQuery($sql, $args);
    }

    /* SUPPRESSION DES CHAPITRES */
    public function deleteChapter($idDeleteChapter){
        $sql = ('DELETE FROM chapter WHERE id=?');
        $args = array($idDeleteChapter);
        return $this->prepareQuery($sql, $args);
   }

   public function updateChapter($updateChapter){
       $sql = ('UPDATE chapter SET ChapterContent=?, ChapterNumber=?, ChapterName=? WHERE id=?');
       $args = array($updateChapter->getAllChapterContent(),$updateChapter->getChapterNumber(), $updateChapter->getChapterName(), $updateChapter->getId() );
       return $this->prepareQuery($sql, $args);
   }
}   