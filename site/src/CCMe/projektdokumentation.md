

Krav K1 - Installera från GitHub
--------------------------------
Har haft mycket strul med GitHub under kursens gång, och har det fortfarande. Framförallt är det bristen på grafiskt
gränssnitt som gör att jag har svårt att ta till mig de olika begreppen (stage, commit, branch, etc). 
Tyckte det blev för krångligt att hålla på med GitHub ett tag och skapade helt enkelt ett nytt repo för varje nytt kursmoment.
I och med att jag inte använder mig av GitHub under utvecklingen så blir det bara ett extra (irritations)moment att hålla på 
med. Jag tycker processen *lokal utveckling -> färdigställning -> FTP till driftserver -> konfigurering* fungerar bra så länge
det bara är jag själv som sysslar med projektet. 

Under utvecklingen av projektarbetet tog jag mig dock i kragen och använde mig av GitHub. Committade ändringar och hämtade 
ner till BTH's server för att testköra osv. Ett problem som ställer till det mycket är dock att vissa filer måste vara olika
på den lokala servern och BTH-servern, t.ex. .htaccess. Det går säkert att lösa på nåt bra sätt, men jag kände att jag inte
hade tid att sätta mig in i det ordentligt, så det blev lite snabbfixar med bl.a. *git stash save* och *git stash drop* för
att kunna hämta ner nya versioner från GitHub efter att jag ändrat .htaccess. Sen fick jag in och pilla med Notepad++ i 
efterhand. Mycket meckigt och långtifrån så som det är tänkt att Git ska fungera antar jag.


Krav K2 - Den berömda 5-minuterinstallationen (valfritt)
---------------------------------------------
Oj oj oj, här slösade jag bort mycket tid! Hade storslagna planer på ett installationsgränssnitt där allt skulle gå
automtiskt och man skulle kunna göra de flesta inställningarna direkt i webbgränssnittet. Det fungerade bra ända tills jag
testade det på min referensinstallation och ingenting fungerade. Av någon anledning kunde jag inte få PHP att ändra 
skrivrättigheterna på kataloger och filer, och utan det gick det ju inte ens att skriva till config.php, så där föll
alltihopa pladask. Då skulle man i vilket fall som helsändra t vara tvungen att ändra rättigheterna manuellt, och då känns det
ju lite meningslöst med ett webbgränssnitt...

De delar som blev kvar är kontrollen av att servern uppfyller de krav som ramverket har för att kunna köras (tex. PHP-version,
SQLite, filrättigheter), samt installationen av de enskilda modulerna i ramverket. Istället fick det bli så att instruktionerna
för vad som måste göras för att kunna installera ramverket fick hamna i README-filen. Där finns även instruktioner för hur
man ändrar i config.php. Jag är inte helt nöjd med resultatet, men har inte tid att lägga ner på att få igång ett helt
automatiserat installationsgränssnitt. Det blev iallafall ett halvhjärtat försök som tyvärr misslyckades...


Krav K3 - Ett anpassningsbart ramverk
-------------------------------------
Temat är i princip samma som jag använt genom hela kursen. Jag har försökt hålla det så enkelt som möjligt, med ett 
stilrent och lättöverskådligt utseende. 

Instruktionerna för hur man ändrar utseende på ramverket kunde fyllt en hel bok känns det som! Jag valde att göra
dem "lagom" detaljerade men det krävs ju att den som ska ändra utseende på webbplatsen har kännedom om CSS, PHP och HTML.
I mitt fallerade försök till webbgränssnitt hade jag en idé om att menyerna skulle kunna anges i XML-format, vilket
gjort det hela lite mer lättanvänt. Nu blev det ju inte så, och alltså måste man in och rota i config.php för att ändra
menyerna manuellt. Jag vet inte om jag tycker det är en riktigt bra lösning eller ej. Jag skulle nog föredra att göra
ramverket lite "lösare" och låta användaren ordna menyerna direkt i HTML-kod istället (vilket ju även går att göra såklart).

Krav K5 - Valfri (valfritt)
---------------------------
Jag kunde inte komma på **en** förbättring som var i rätt storleksordning, och gjorde istället ett par mindre förbättringar.


**Visa innehåll baserat på användare**  
Genom att göra en del ändringar i CCContent och CMContent lade jag till en listning av användare på samma sida som allt 
innehåll listas. Genom att klicka på en användare kan man visa allt innehåll från enbart den användaren. 


**Textfilter**  
Jag upptäckte att det fanns två olika textfilter i Lydia - dels CTextFilter som vi skapade i ett av kursmomenten, men även
CMContent::Filter() vilken gjorde i princip samma sak som CTextFilter::Filter(), fast med färre filter att välja mellan. Jag gjorde
det enkelt för mig och uppdaterade CMContent::Filter() till att använda CTextFilter::Filter() för att filtrera innehåll. På
så vis behövde jag inte leta upp alla de ställen där CMContent::Filter() används och ändra överallt.


Krav K6 - Projektdokumentation och referensinstallation
-------------------------------------------------------
**Nexus MVC på GitHub**  
https://github.com/BadCash/nexus_exam

**Referensinstallation**  
http://www.student.bth.se/~mawi13/phpmvc/nexus_exam/  
För inloggning kan man använda root/root eller doe/doe (användarnamn/lösenord)

**Mina tankar kring Nexus MVC**  
Jag vet inte riktigt vad jag tycker om mitt ramverk. I den form det har i nuläget tycker jag det känns väldigt ofärdigt. Själva 
poängen med ett ramverk är ju att det ska förenkla för den som ska göra en webbplats, och på ett sätt kan man väl säga
att Nexus/Lydia gör det. Å andra sidan blir det mycket meckande om man vill göra något "utanför ramarna", och det känns
inte alltid helt självklart var saker ska göras och vad som händer bakom kulisserna - trots att koden vuxit fram steg för steg
under kursens gång. 

Jag tycker det känns som att ramverket i sin nuvarande form stjälper mer än det hjälper, och skulle nog snarare se ett mer
minimalistiskt ramverk som följer KISS-principen. Som jag skrivit i någon tidigare redovisningtext har jag tidigare använt
mig av nåt slags MVC-liknande struktur på mina PHP-skript, framförallt när det gäller formulärhantering. Men istället för
att sprida ut allting i olika kataloger har jag helt enkelt lagt allt i samma PHP-fil, men inuti olika funktioner. Det gör
det enkelt att styra programflödet dit man vill. Vill jag först processa ett formulär och sedan anitngen visa felmeddelanden
eller nästa formulär anropar jag bara respektive funktioner. Det känns som att man får mer kontroll över vad som sker. I
Nexus är det inte alltid helt givet vilken rutt programflödet tar, och ramverket har nu växt till en svåröverskådlig
mängd funktioner och klasser. 

Jag skulle inte välja att använda mitt ramverk som grund för en riktig hemsida, utan antingen satsa på ett färdigt MVC-ramverk
eller en enklare hemmagjord lösning. Självklart kan man bygga vidare och förbättra, men det känns som att uppfinna hjulet
på nytt när det redan existerar kompletta ramverk med både mer funktionalitet, stabilitet, kunskapsbas och dokumentation.
Det känns också lite som att ramverket gått lite från rent MVC till något slags CMS. Det kan såklart vara en bra inbyggd
funktionalitet, men även här finns det färdiga lösningar som är väl genomarbetade och uppdateras regelbundet.

För det allra mesta har jag följt övningarna och i princip klonat Lydia. Med avsteg för vissa finjusteringar som nämns i
krav K5. Jag valde också tidigt att lägga in min Me-sida som en "applikation/site" i ramverket. Det gick faktiskt väldigt
enkelt, och resultatet blev mycket bra. Framförallt blev jag nöjd med att jag kunde göra om min redovisningssida till
Markdown-format. Jag skapade även en kontroller & modell för att visa källkod (CCSource, CMSource), baserad på source.php men jag fick skriva om mycket
av koden för att få rätt på sökvägar etc. 