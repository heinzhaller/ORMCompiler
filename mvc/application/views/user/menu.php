<div class="row">
	<!--Begin Sidebar Menu-->
	<div class="col-md-3">
		<ul class="list-group sidebar">
                    <h4>Verfügbare Spieleartikel</h4>                        
			{foreach gamelist as key => game}
                            <li class="list-group-item">
                                <h5>{game.title}</h5><div align="right"><a href="/Game/Edit/?gameid={game.gameid}">(Editieren)</a> - <a href="/Game/Show/?gameid={game.gameid}" target="_blank">(Anzeigen)</a></div>
                            </li>
			{/foreach}
		</ul>
		<a class="btn-u" href="/Game/Add">Spiel hinzufügen</a>
	</div>
	<!--End Sidebar Menu-->

	<!--Begin Content-->
	<div class="col-md-9">
		<!--Service Blcoks -->
		<div class="row servive-block margin-bottom-10">

			<div class="col-md-6 col-sm-6">
				<div class="servive-block-in servive-block-colored servive-block-green">
					<h4>Account bestätigt</h4>
					<div><i class="icon-ok"></i></div>
					<p>Du kannst jetzt Artikel für BrowsergameBase schreiben.</p>
				</div>
			</div>

			<div class="col-md-6 col-sm-6">
				<div class="servive-block-in servive-block-colored servive-block-blue">
					<h4>Artikel / Spiel hinzufügen</h4>
					<div><i class="icon-cloud-download"></i></div>
					<p>Du kannst Artikel zu einem bestimmten Spiel hinzufügen.</p>
				</div>
			</div>
		</div><!--/servive-block-->
		<!--End Service Blcoks -->

		<div class="row">

			<div class="col-md-12 col-sm-12">
                            <a class="btn-u" href="/Game/Add">Spiel hinzufügen</a>
			</div>
		</div>

	</div>
	<!--End Content-->
</div>