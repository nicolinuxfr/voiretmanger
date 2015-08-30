<form method="get" id="searchform"  action="<?php bloginfo('home'); ?>/"> 
	<input class="case" type="text" autofocus value="Chercher" placeholder="Chercher" id="search" name="s" onblur="if (this.value == '')  {this.value = 'Chercher';}"  onfocus="if (this.value == 'Chercher') {this.value = '';}" /> 
	<input type="hidden" id="searchsubmit" /> 
</form>

<nav>
	<ul id="results"></ul>
</nav>
