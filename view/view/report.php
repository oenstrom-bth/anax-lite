<div class="row">
    <div class="col-8">
        <h1>Redovisning</h1>
        <p>Här hittar du alla mina redovisningstexter för kursen 'oophp'.</p>

        <hr>

        <h2 id="kmom01">Kmom01</h2>
        <h3>Hur känns det att hoppa rakt in i klasser med PHP, gick det bra?</h3>
        <p>Tycker det gick bra. Det var lite annorlunda mot Python men känner ändå att jag fick ganska bra grepp om det. Det är lite mer saker att hålla reda på i PHP jämfört med objektorienterad Python.</p>
        <p>Guess the number-uppgiften gick bra att göra och hade inga speciella problem med den. Det tog lite längre tid att göra den än vad det borde. Hade svårt att koncentrera mig när jag gjorde den, men det blev bra till slut. Att göra den med ett objekt i sessionen tycker jag absolut var det smidigaste och bästa sättet.</p>
        <p>När det kommer till extrauppgifterna i “Guess the number”, valde jag att ge sidorna ett enkelt och stilrent utseende. Jag lade inte jättemycket tid på att styla men tycker ändå resultatet blev snyggt och bra. Jag valde däremot att inte integrera det i ramverket.</p>

        <h3>Berätta om dina reflektioner kring ramverk, anax-lite och din me-sida.</h3>
        <p>Tycker det ska bli riktigt kul att lära sig göra ramverk och få lite koll på hur det fungerar. Tillsammans med den andra kursen så tog uppgifterna ganska mycket tid vilket gjorde att jag inte hade tid att försöka ändra och förbättra ramverket själv. Men det kommer väl längre in i kursen.</p>
        <p>Jag skapade en vy för byline, en för flash-bild och en för en testsida. Flash-bilden använder jag på varje sida men bylinen finns däremot inte på förstasidan. Jag använder också Cimage på sidan för att hantera bilderna.</p>
        <p>Navbaren valde jag att dela upp i två filer, en config-fil och en vy-fil. Config-filen returnerar en array med alla routes som ska skapas. Vy-filen använder sedan en rekursiv funktion för att generera html-koden. Den har alltså stöd för ett godtyckligt antal undermenyer.</p>
        <p>När det kommer till styling av sidan valde jag att använda LESS. LESS-filerna lade jag i mappen “theme” och där i finns även en make-fil för att kompilera LESS till CSS. Det fungerar alltså likt sättet vi använde oss av i Anax Flat. För att inte helt behöva bygga upp allt från grunden använder jag mig av Preboot. Detta ger mig bland annat ett enkelt gridsystem att utgå ifrån och lite annat smått och gott. Jag känner att jag får mycket större frihet med Preboot jämfört med Bootstrap, något jag gillar.</p>
        <p>För tillfället ligger den mesta LESS-koden i samma fil. Jag planerar dock att dela upp det i flera olika moduler för att få bättre struktur. Navbaren har däremot en egen modul och jag har byggt upp den helt själv från grunden. Det finns lite saker att förbättra med den, men jag är väldigt nöjd med den trots att det inte är något jätteavancerat. Den har till exempel stöd för hur många undermenyer som helst.</p>

        <h3>Gick det bra att komma igång med MySQL, har du liknande erfarenheter sedan tidigare?</h3>
        <p>Det var absolut inga problem. Vi har i tidigare kurser jobbat med SQLite vilket gjorde allt lättare. Jag har även tidigare använt både MySQL och MariaDB så det var inga nyheter precis.</p>
        <p>I uppgiften jobbade jag mot BTHs server vilket gjorde att jag inte kunde skapa och ta bort databaser. Jag använde mig av engelska namn istället för svenska, då det känns bättre helt enkelt. Jag gjorde fram till övning 9 i uppgiften och hade inga problem alls. Kommer nog göra klart uppgiften i nästa kursmoment.</p>

        <hr>

        <h2 id="kmom02">Kmom02</h2>
        <h3>Hur känns det att skriva kod utanför och inuti ramverket, ser du fördelar och nackdelar med de olika sätten?</h3>
        <p>Har inte riktigt tänkt på det. Känner ingen större skillnad, kod som kod. Däremot blir det smidigt av att skriva direkt i ramverket, navbaren till exempel blir väldigt lättanvänd. Sen är ju frågan om navbaren ska vara direkt integrerad i ramverket eller ej.</p>
        <p>På tal om navbaren så är jag väldigt nöjd med den. Använder två setter-metoder för att få tillgång till den nuvarande routen och för att kunna skapa länkar. Sedan använder jag metoden “getHtml” för att generera HTML-kod för navbaren. Metoden är rekursiv vilket gör det väldigt enkelt att skapa “oändligt” med undermenyer. Menyns struktur är uppbyggd av en multi-dimensionell array som ligger under “config/navbar.php”.</p>
        <p>Men som sagt smidigt att skriva direkt i ramverket, gör det lättare att använda sakerna på andra ställen, till exempel i vy-filerna.</p>

        <h3>Hur väljer du att organisera dina vyer?</h3>
        <p>Jag valde att använda en layout-fil. Layout-filen och de nya vyerna ligger för tillfället under “view/view/”. Jag känner att använda layout-filer kommer göra det smidigare och lättare längre fram. Gjorde även på liknande sätt i projektet för “oopython”-kursen och gillade det.</p>

        <h3>Berätta om hur du löste integreringen av klassen Session.</h3>
        <p>Session-klassen ligger under “src/Session/Session.php”. Sedan lade jag till en ny “Session()” i “$app” inne i “index.php”. Vill man ha flera olika sessioner får man skapa en ny session på sidan i fråga. Detta testade jag att göra i uppgiften för tärningsspelet, se nedan.</p>
        <p>För att testa sessionen gjorde jag en ny fil för routes:n och en ny vy-fil. Vy-filen använder jag till routen “session” och “session/dump”. Resterande routes hanteras direkt i “config/route/session.php” då de inte behöver visa upp något. Så inga onödiga vy-filer.</p>

        <h3>Berätta om hur du löste uppgiften med Tärningsspelet 100/Månadskalendern, hur du tänkte, planerade och utförde uppgiften samt hur du organiserade din kod?</h3>
        <p>Jag valde att göra tärningsspelet, detta på grund av att jag hade tänkt göra båda uppgifterna man hann inte. Då jag redan hade börjat med tärningsspelet ville jag inte byta.</p>
        <p>Tanken var att vyn skulle göra så lite som möjligt, endast skriva ut information från Game-objektet. Då jag inte heller ville ha HTML-kod i klasserna fick det bli någon if-sats och loop för att skriva ut innehåll beroende på svar från Game-objektet. Då jag heller inte ville blanda ihop sessionen för sessions-sidan och spelet gjorde jag en ny session för spelet.</p>
        <p>Till uppgiften använder jag tre klasser, Game, Round och Dice. Game-klassen hanterar spelarna och deras information. Det är också Game-klassen som skickar information till vyn. Round-klassen hanterar varje runda i spelet och använder Dice-klassen för att slå tärningen och hämta poäng.</p>
        <p>Round-och Dice-klassen känner jag hade kunnat slagits ihop. Något jag gjorde från början. Jag ändrade till att använda tre klasser för att se om det blev smidigare och bättre av det. Men som sagt, det tycker jag inte det blev. Då det blev lite ont om tid mot slutet hade jag inte riktigt tid att ändra tillbaka till två klasser, men det fungerar ju trots allt ändå.</p>

        <h3>Några tankar kring SQL så här långt?</h3>
        <p>Inget speciellt. Det jag har gjort hittills i SQL tycker jag inte har varit särskilt svårt. Jag vet däremot att det går skriva riktigt komplicerade SQL-satser som gör att man får tänka ett par extra gånger och ger en huvudvärk. När det kommer till vad jag tycker om SQL och databaser, så är det inget jag tycker är särskilt kul. Smidigt att använda men inte riktigt min grej.</p>

        <hr>

        <h2 id="kmom03">Kmom03</h2>
        <h3>Hur kändes det att jobba med PHP PDO, SQL och MySQL?</h3>
        <p>Det var inga särskilda problem. Har tidigare använt alla fyra. Dock inte så mycket PDO. MySQL och MariaDB har jag använt ett antal gånger tidigare så att jobba med det och göra SQL-uppgiften var inga problem. PDO har jag testat på någon gång tidigare, men det är först nu jag vet hur smidigt det är.</p>

        <h3>Reflektera kring koden du skrev för att lösa uppgifterna, klasser, formulär, integration Anax Lite?</h3>
        <p>Jag gjorde en ny PHP-fil för routes till login-sidor och admin-sidor. Där i kontrolleras det om man är inloggad och om man är bannad eller ej. Admin-sidorna kan man endast komma åt om man har rätt behörighet.</p>
        <p>För att hantera användare gjorde jag två klasser, en klass som representerar just en användare och en klass som hanterar kopplingen med databasen. Strukturen tycker jag blev ganska bra vilket gjorde att jag kunde återanvända samma formulär till att ändra sin profil och att ändra någon annans profil som admin. Jag lyckades också hålla vyerna rena och “dumma”, vilket blev bra.</p>
        <p>Jag testade också att göra en forumlärklass för att hantera validering av formulär. Klassen har en metod för att kolla att alla fält är ifyllda som ska vara ifyllda och en validate-metod för att validera vissa fält. Valideringsmetoden kontrollerar att användarnamnet är unikt, att e-postadressen är unik, att e-postadressen är giltig, att lösenordet är korrekt och att fälten för det nya lösenordet stämmer överens.</p>
        <p>Då det blev väldigt ont om tid så är formulärklassen inte den bästa, men den fungerar. Strukturen överlag hade jag också gärnat jobba mycket mer på. Förbättra och finslipa klasserna hade jag också velat ha mer tid till. Men som sagt, det blev ont om tid mot slutet.</p>
        <p>Vill du logga in på sidan kan du använda användarnamnet ‘admin’ med lösenordet ‘password’. Resterande användare hittar du på sidan när du är inloggad som admin och alla använder lösenordet ‘password’.</p>

        <h3>Känner du dig hemma i ramverket, dess komponenter och struktur?</h3>
        <p>Hemma är väl att ta i än så länge. Då det har tagit ganska lång tid att göra uppgifterna har det varit svårt att hinna komma in i ramverket så mycket som jag skulle vilja. Men det har ändå gått ganska bra och jag känner att jag börjar komma in i ramverket och strukturen allt mer och mer.</p>

        <h3>Hur bedömer du svårighetsgraden på kursens inledande kursmoment, känner du att du lär dig något/bra saker?</h3>
        <p>Svårighetsgraden tycker jag har varit bra. Det har dock varit väldigt mycket att göra. Jag har lärt mig mycket bra saker men känner att det har varit för lite tid för att verkligen lära mig så mycket som möjligt. Mot slutet fick jag skynda mig igenom resten för att hinna bli klar innan nästa kursmoment.</p>
        <p>Kort sagt, det svåraste har varit att hinna göra allt och göra det bra. Jag har inte riktigt hunnit finslipa på sakerna som jag brukar göra.</p>

        <hr>

        <h2 id="kmom04">Kmom04</h2>
        <h3>Finns något att säga kring din klass för texfilter, eller rent allmänt om formatering och filtrering av text som sparas i databasen av användaren?</h3>
        <p>Jag valde att göra en egen klass istället för att låna CTextFilter-klassen. Kände att det nästan skulle ta längre tid att integrera och använda den än att skriva en själv. Klassen har endast det som behövs, inget extra som CTextFilter har. Dock gjorde jag de extra metoderna för strip tags och htmlspecialchars.</p>
        <p>När det kommer till filtrering och formatering av text kan man fråga sig om det är bäst att göra det innan det läggs in i databasen eller när det skrivs ut. På ett sätt tycker jag det är bättre att göra det när texten skrivs in. Det är antagligen färre ställen det då behöver göras på. Vilket gör att det är mindre risk att man glömmer göra det någonstans. En subjektiv fråga, det viktiga är att man gör det i alla fall.</p>

        <h3>Berätta hur du tänkte när du strukturerade klasserna och databasen för webbsidor och bloggposter?</h3>
        <p>Jag ville ha en klass som tog hand om kopplingen till databasen och sen försöka ha någon eller några klasser för själva innehållet. Det fick bli klassen ContentDao som pratar med databasen och en Content-klass som representerar innehåll i databasen. Det blev även en liten Blog-klass som ärver från Content-klassen. Dao-klassen har hand om CRUD-funktionaliteten och Content-klassen har ett par metoder som underlättar för Dao-klassen. Blog-klassen har i sin tur sedan en metod för att hämta  ut ingressen ur inlägget.</p>

        <h3>Förklara vilka routes som används för att demonstrera funktionaliteten för webbsidor och blogg (så att en utomstående kan testa).</h3>
        <p>Bloggen ligger under routen “/blog” och inläggen ligger i sin tur under “/blog/inlägg-här”. Sidorna ligger under “/page/sida-här” och för att visa att typen block fungerar finns sidan “/page-with-block”. Allt detta går även att hitta via navbaren under “Uppgifter->Kmom04”. Där finns även en länk till sidan som visar upp filterna i TextFilter-klassen.</p>

        <h3>Hur känns det att dokumentera databasen så här i efterhand?</h3>
        <p>Nu var det ingen jättestor databas och inte så mycket dokumentation som skulle göras. Men det känns bra ändå. Det ger en bra överblick och det kan ge en lite bättre förståelse för allt, speciellt när det kommer till större databaser.</p>

        <h3>Om du är självkritisk till koden du skriver i Anax Lite, ser du förbättringspotential och möjligheter till alternativ struktur av din kod?</h3>
        <p>Ja det ser jag, nästan hela tiden. Efter varje kursmoment hittar jag alltid saker jag skulle vilja ha gjort eller vilja försökt göra annorlunda. Då uppgifterna tar ganska lång tid är det svårt att hinna med att förbättra och ändra det man skulle vilja. Den här gången hann jag dock ändra lite när det kommer till vyerna och det blev även några hjälpfunktioner i “functions.php” och “App.php”.</p>

        <hr>

        <h2 id="kmom05">Kmom05</h2>
        <h3>Gick det bra att komma igång med det vi kallar programmering av databas, med transaktioner, lagrade procedurer, triggers, funktioner?</h3>
        <p>Har aldrig programmerat på det sättet i en databas tidigare, knappt sett det faktiskt. Så det var helt nytt för mig. Trots det tycker jag att det gick bra att komma igång med det.</p>

        <h3>Hur är din syn på att programmera på detta viset i databasen?</h3>
        <p>Har använt MySQL ett antal gånger tidigare men aldrig kommit in på att programmera på detta sättet. Jag tycker det kändes riktigt smidigt och bra. Det underlättar väldigt mycket om du inte behöver skriva allting i PHP eller det språk du nu använder.</p>

        <h3>Några reflektioner kring din kod för backenden till webbshopen?</h3>
        <p>Det blev inte att jag lade så mycket tid på just PHP-biten i backenden. Detta då att koda SQL på det här sättet var nytt för mig, vilket gjorde att det gick lite mer tid där. Med mer tid hade jag förbättrat PHP-delen, men allt fungerar åtminstone som det ska.</p>
        <p>Jag valde att fokusera lite mer på krav 5, 6 och 7 då det är vad kursmomentet handlar om. Till kundvagnen använder jag tre procedurer vilket gör användandet enkelt. En för att lägga till i kundvagnen, en för att ta bort och en för att visa. På samma sätt hanterar jag en order. Tre procedurer, skapa, ta bort och visa. För att skapa en order loopas en kundvagns innehåll igenom och läggs till i ordern, samtidigt tas produkterna bort från lagret. Tar man bort en order så markeras den som borttagen, den försvinner ej, och produkterna åker tillbaka till lagret. Många av procedurerna innehåller transaktioner.</p>
        <p>För att enkelt få reda på lagersaldot av en produkt gjorde jag en egendefinierad funktion som hämtar ut det. Det gör det väldigt enkelt att hämta ut lagret samtidigt som man gör en SELECT-sats på produkter.</p>
        <p>Lagerrapporten hanteras av en trigger på “Inventory”-tabellen som sker efter en UPDATE. Är det nya lagersaldot av produkten under 5 så läggs det in en rad i tabellen “InventoryLog”. Proceduren “getInventoryLog” hämtar sedan ut den loggen. Här borde man kanske ha något bättre sätt att markera vilka produkter vars lager har blivit påfyllt igen. Men det fungerar ändå helt okej som det är just nu.</p>
        <p>Över lag är jag nöjd trots att jag aldrig har gjort det tidigare och som sagt lade jag mest tid på krav 5, 6, 7 och inte så mycket på PHP-delen.</p>

        <h3>Något du vill säga om koden generellt i och kring Anax Lite?</h3>
        <p>Jag känner ofta att det är saker som borde gå att göra bättre och jag hade gärna försökt förbättra det själv. Det som hindrar mig är tiden. Kursen har tagit upp mycket tid vilket har gjort att jag varken har haft tid eller ork att riktigt dyka ner djupare i koden. Men jag försöker förbättra och ändra så mycket jag hinner och orkar.</p>

        <hr>

        <h2 id="kmom06">Kmom06</h2>
        <p>Redovisningstext för kmom06 här.</p>

        <hr>

        <h2 id="kmom10">Kmom10</h2>
        <p>Redovisningstext för kmom10 här.</p>
    </div>
    <div class="col-4">
        <h2>Kursmoment</h2>
        <ul>
            <li><a href="#kmom01">Kmom01</a></li>
            <li><a href="#kmom02">Kmom02</a></li>
            <li><a href="#kmom03">Kmom03</a></li>
            <li><a href="#kmom04">Kmom04</a></li>
            <li><a href="#kmom05">Kmom05</a></li>
            <li><a href="#kmom06">Kmom06</a></li>
            <li><a href="#kmom10">Kmom10</a></li>
        </ul>
    </div>
</div>
