# Gradeyouruni


# Anotace
Tato práce se zabývá webovou aplikací, v níž uživatelé hodnotí vysoké školy. Aplikace tyto informace shromažďuje, zpracovává a dalším uživatelům zobrazuje.

# 1.Úvod
Tento dokument popisuje projekt s názvem Gradeyouruni. 

Projekt vznikl za účelem ulehčit studentům výběr vysoké školy a dát možnost stávajícím studentům univerzit zhodnotit jejich studium.


Před uživatele, který chce ohodnotit svoji univerzitu, je po zadání osobních údajů a zvolení konkrétní univerzity postavena řada otázek, kde pomocí stupnice 1-5 (1 - nejhorší; 5 - nejlepší) vyjádří svůj názor na danou univerzitu. 
Odpovědi jsou poté zpracovány a připraveny pro zobrazení dalším uživatelům.


Student, který chce pomoci při výběru školy, zadá dvě požadované školy, fakulty a studijní programy, o které by měl zájem. Systém mu zobrazí zpracované a zprůměrované odpovědi od předchozích uživatelů. Má tak jasný přehled o tom v čem škola vyniká a naopak strádá.
 

Důvod k vytvoření tohoto projektu byl ten, že se chystám na vysokou školu a aplikace jako je tahle by mi ušetřila spoustu času při rozhodování. Myslím si, že aplikace jako je tahle, by mohla snížit počet studentů, kteří opouští vysoké školy v prvním ročníku.

# 2.Použité technologie 
## HTML, CSS
Html je kostrou celé webové aplikace. Značí veškerý obsah na stránce. Kaskádové styly neboli CSS je použito k formátování celého projektu.

## JavaScript
JavaScript (JS) je skriptovací jazyk učený pro tvorbu moderních dynamických webů. Dnes ho již najdeme téměř na každém webu. Jeho hlavní výhoda je, že umožňuje změnu obsahu, bez potřeby fyzického znovunačtení stránky. 


V projektu je JavaScript jen při ikoně X, která má za úkol smazat veškerý text zadaný uživatelem v políčku.
```

<input type="button" class="material-icons" id="reset" value="&#xe5cd; "onclick="document.getElementById('nazev').value = ''">
```

Funkce _onclick_ se vyvolá při stisknutí levého tlačítka myši na ikonu. Funkce _.getElementByID_ najde input podle ID auvnitř se nastaví prázdná hodnota bez nutnosti znovu načíst dokument.

## PHP
Jedná se o populární skriptovací/programovací jazyk, který je určený pro vznik internetových stránek a webových aplikací. 

Všechny prováděné operace se odehrávají na webovém serveru - tzn. výpočet operace je proveden tam, kde je zdrojový kód webu a do prohlížeče se projektuje pouze už hotový výsledek operace (na rozdíl od JavaScript nebo HTML).  

Technologie PHP je hlavní částí projektu. Je využita v 90% projektu. Příklad využití PHP je kontrola prázdnoty polička.



```

    $nazev = $_SESSION[ "dotaznik" ][ "nazev" ];
        if ( $nazev == "" ) {
         print( "
        <style>
         #nazev {
          background-color: #B82B2D;
      }
        </style>" );
        }

```

Pokud je stisknuto tlačítko další, nahraje se do proměnné _$nazev_ text z daného inputu ve formuláři. Podmínka _If_ zkontroluje, jestli je proměnná prázdná. Pokud ano, změní v css barvu políčka na červenou. Tím se upozorní uživatel, aby dané políčko vyplnil.


## MySQL a SQL
V projektu je použita databáze, kde jsou uloženy:

  údaje o uživatelích, kteří ohodnotili svou univerzitu
  školy
  fakulty 
  studijní programy
  města
  jednotlivá hodnocení
 
Pro databázi je použitý systém MySQL, který je součástí WAMP serveru. Komunikaci mezi databází a programem zajišťuje dotazovací jazyk SQL.

```

SELECT CAST(AVG(hzazemi) 
AS DECIMAL(3,2)) 
FROM hodnoceni 
LEFT JOIN `bcprogramy` 
ON `bcprogramy`.`idfakulty` = `hodnoceni`.`idfakulty` 
WHERE `bcprogramy`.`idprogramu`= '$idprogramu';
```
Příkazem _SELECT_ zvolíme, co budeme chtít vypsat z databáze. V našem případě je to hzazemi (hodnocení zázemí). To potřebujeme zprůměrovat a zaokrouhlit. 

První použijme příkaz _CAST_, který má za úkol hodnotu přeměnit. Příkazem _AVG_ zprůměrujeme hzazemi a zaokrouhlíme příkazem _AS DECIMAL (3,2)_ kde hodnota 3 udává celkový možný počet míst v čísle (3,87; 6,25;  nelze 354,54) a hodnota 2 počet desetinných míst (8,56). Tzn. Číslo může mít pouze jednotku a dvě desetinná místa, což v tomto případě dostačuje (Hodnocení je pouze od 1 do 5).


Příkaz _FROM_ určuje, z jaké tabulky budeme data načítat. V našem případě z tabulky hodnocení. _LEFT_ _JOIN_ propojuje tabulku (bcprogramy s tabulkou hodnocení) na základě idfakulty kde (_WHERE_) se idprogramu shoduje s proměnnou _$idprogramu_.
## LaTeX
Pro zdokumentování naší závěrečné práce jsme využili sázecího systému LaTeX. 

Pro tvorbu teoretické části práce byl použit systém LaTeX. Samotné psaní práce proběhlo v aplikaci 
Overleaf www.overleaf.com,


# Hlavní části aplikace
Stránka má dvě část – část pro vložení hodnocení o univerzitě a část pro výpis již zadaných hodnocení.

## Uděl hodnocení tvé univerzitě

### Krok 1
Zde uživatel zadá své osobní údaje. Je to z důvodu, aby se předešlo duplikaci hodnocení. Každé hodnocení je vázáno na jeden e-mail. Políčka jsou opatřeny validací, takže se nestane, že by uživatel zadal údaje v nesprávném formátu. Údaje se po úspěšné validaci zapíšou do SESSION a posledním kroku do databáze.


### Krok 2

V druhém kroku uživatel zvolí univerzitu, kterou by chtěl ohodnotit.


### Krok 3-4

V následujících krocích uživatel zvolí univerzitu, fakultu a konkrétní studijní program, který studoval. V případě, že chce změnit údaje v předchozím kroku, je možné se k nim vrátit pomocí tlačítka zpět.

### Krok 5

Na závěr uživatel odpoví na otázky formou stupnice 1-5 (kde 5 je nejlepší a 1 nejhorší). Dále může napsat písemnou recenzi, ovšem políčko může zůstat prázdné.


Další stránka uživatele ujistí, že vše proběhlo v~pořádku a~navede ho odkazem zpět na hlavní stránku. 




## Podívej se na hodnocení tvé univerzity
### Krok 1-3

V této části uživatel zadá dvě univerzity ke srovnání. V následujících krocích zvolí fakulty a studijní programy.



### Výpis hodnocení
Na závěr se zobrazí přehledná tabulka s údaji o školách. Hodnoty se zaokrouhlují, takže jsou zobrazeny pouze přibližné hodnoty. Uživatel tak jasně vidí, které školy studenti preferují více a které méně a co konkrétně jim vadí a co naopak vyzdvihují.


# Databáze

Veškeré údaje o uživatelích a univerzitách jsou uloženy v databázi. Databáze je složena z 6 navzájem propojených tabulek. Tabulky jsou propojeny pomocí jednotlivých ID.





# Session 

K dočasnému ukládání dat mezi jednotlivými formuláři je použita session.

 Je to superglobální pole, které umožňuje předávání dat přes více stránek. Nemusíme tedy předávat hodnoty přes URL.

## Nastartování session


Na začátku formuláře, musíme nejprve session nastartovat a~pojmenovat.

```
    session_start();
     if ( isset( $_POST[ "next" ] ) ) {
            foreach ( $_POST as $key => $value ) {
             $_SESSION[ "info" ][ $key ] = $value;
          }
    
      $keys = array_keys( $_SESSION[ "info" ] );
      if ( in_array( "next", $keys ) ) {
           unset( $_SESSION[ "info" ][ "next" ] );
          }
     }
 ```


V průběhu formulářů se do _session_ zapisují jednotlivé informace od uživatele. Na konci formuláře se všechny data ze _session_ zapíšou do databáze. Údaje se do databáze nezapisují hned z prostého důvodu. Uživatel se může splést ve svých údajích a bude se chtít vrátit zpět. V tomto případě už by přepis byl mnohem složitější. Výhodou _session_ je, že uživatel může mezi formuláři své údaje měnit.

## Extract
Na konci formuláře, pokud je pole definováno, extrahujeme data ze _$_SESSION_ a zapíšeme je do proměnných. K tomu použijeme příkaz _extract_. Ten vytvoří proměnné s totožným názvem jako prevk z pole a zapíše do ní obsah prvku např. _$_SESSION[ "dotaznik" ][ "nazev" ]_ -> _$nazev_

```
 if ( isset( $_SESSION[ "dotaznik" ] ) ) {

  extract( $_SESSION[ "dotaznik" ] );
 }
  
```
# Připojení do databáze

Pro připojení do databáze použijeme příkaz _mysqli_connect_. Ten má 4 atributy IP adresa, přihlašovací jméno, heslo a název databáze.

```
 $conn = mysqli_connect( $servername, $username,
      $password, $dbname );

 if ( !$conn ) {
     error_log('Connection error: ' . mysqli_connect_error());
 }

 mysqli_query( $conn, "set names 'utf8'" );
 ```
# Ikony hvězdiček
Dalším úkolem bylo udělat hodnocení přehledné a jednoduché. Hodnocení pomocí hvězdiček bylo ideální volbou. K tomu bylo nutné udělat řadu podmínek, které pokud hodnocení překročí nějakou hodnotu, zobrazí ikonu hvězdy či poloviční hvězdy
```
if ( $row[ "CAST(AVG(hzazemi) AS DECIMAL(3,2))" ] > 0.6 &&
       $row[ "CAST(AVG(hzazemi) AS DECIMAL(3,2))" ] <= 1.3 ){
       print( '<img src="star.png" alt="hvězda"></td>' );

 }

```
Příkaz říká, že když bude průměr hodnocení zázemí zaokrouhlený na dvě desetinná místa, vetší než 0,6 a zároveň menší než 1,3, tak zobrazí ikonu hvězdy. Skupinou těchto příkazů jsme schopni docílit přepisu čísel na ikony. I když jsme docílili požadavku, tak řešení není úplně optimální, protože se nám v kódu neustále opakují stejné příkazy.


# Závěr


Cílem práce bylo vytvořit aplikaci, která pomůže studentům při hledání jejich ideální vysoké školy. Myslím si, že by aplikace jako je tato mohla snížit počet studentů, kteří opouští vysoké školy v prvním ročníku. Většinou školy na svých stránkách prezentují jenom to, v čem vynikají. Skutečnost je tedy zkreslená. Bohužel spousta studentů zjistí, že jim z nějakých důvodů studium na škole nesedí. A tato aplikace by této situaci mohla předejít.

__Edit 10.7.2023__ 


Maturitní práci jsem dokončil před dvěma lety, od té doby nebyla práce upravována a se současnými znalostmi bych práci napsal jinak. I přesto bych ji chtěl shrnout.

Během tvorby tohto projektu jsem se naučil základy programování v PHP a jak vytvořit funkční strukturu webové aplikace. Použitím základních programovacích prvků, jako jsou proměnné, podmínky, smyčky a funkce, jsem dokázal implementovat různé funkcionality, které byly součástí mého projektu. Mezi tyto funkcionality patřilo například zobrazení dynamického obsahu na stránkách, zpracování a validace formulářů a přístup k databázi.

Tato maturitní práce mi poskytla důležité základy, které mi ulehčily přechod na vysokou školu.






