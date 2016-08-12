<?
#ä
Library::requireLibrary(LibraryKeys::ABSTRACTION_DATABASE_CONNECTION());
Library::requireLibrary(LibraryKeys::APPLICATION_GAMEDAY());
Library::requireLibrary(LibraryKeys::APPLICATION_FIGHT());

Library::requireLibrary(LibraryKeys::APPLICATION_FIGHT_OFFER());
Library::requireLibrary(LibraryKeys::APPLICATION_FIGHTSYSTEM());

$gameday = ( isset($_GET['gameday']) ? (int) $_GET['gameday'] : null);


$myQuery = new FightOfferQuery();
if(!$gameday){
	$myJoinQuery = new GamedayQuery();
	$myJoinQuery->add(FightOfferQuery::GAMEDAYID, Criteria::EQUAL, GamedayQuery::GAMEDAYID);
	$myQuery->addJoin($myJoinQuery, Criteria::JOIN_INNER);
	$myQuery->add(GamedayQuery::REALDATE, Criteria::EQUAL, date('Y-m-d',time()));
}else{
	$myQuery->add(FightOfferQuery::GAMEDAYID, Criteria::EQUAL, $gameday);
}
$myQuery->add(FightOfferQuery::OFFERED_BOXERID, Criteria::ISNOTNULL);
$myQuery->add(FightOfferQuery::BOXERID, Criteria::ISNOTNULL);

$myQuery->add( '(select count(*) from tbl_fight where tbl_fight.fightofferid = tbl_fight_offer.fightofferid ) ',Criteria::EQUAL, 0);
/*
$myJoinQuery = new FightQuery();
$myJoinQuery->add(FightQuery::FIGHTOFFERID, Criteria::EQUAL, FightOfferQuery::FIGHTOFFERID);
$myQuery->addJoin($myJoinQuery, Criteria::JOIN_LEFT);
$myQuery->add(FightQuery::FIGHTID, Criteria::ISNULL);
*/

$myList = $myQuery->find();
$myList instanceof FightOfferList;

foreach ($myList as $myFightOffer){
	$myFightOffer instanceof FightOffer;

	// new fight
  $myFight = new Fight();
  $myFight->setFightofferid($myFightOffer->getFightofferid());
	$myFight->setGamedayid($myFightOffer->getGamedayid());
  $myFight->setTime( strtotime(date('Y-m-d H:00:00', time())) ); // aktuelle stunde
  $myFight->setHallid(0); // debug

	$myBoxer1 = BoxerManager::getBoxerByBoxerid( $myFightOffer->getIsHomeMatch() ? $myFightOffer->getBoxerid() : $myFightOffer->getOfferedBoxerid() );
	$myBoxer2 = BoxerManager::getBoxerByBoxerid( $myFightOffer->getIsHomeMatch() ? $myFightOffer->getOfferedBoxerid() : $myFightOffer->getBoxerid() );

	$myFight->setBoxerDefender($myBoxer1);
  $myFight->setBoxerChallenger($myBoxer2);

  FightManager::saveOnly($myFight);
	$myResult = FightSystem::berechneKampf($myFight);

	//DBConnection::rollback();// debug
	DBConnection::commit();


	break; // eine kampfberechnung reicht erstmal
}

//DBConnection::disconnect();
