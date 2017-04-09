<div class="col-8">
    <h1>Om sidan</h1>
    <p>Den här sidan är gjord i kursen 'oophp'. I kursen lär vi oss objektorienterad programmering i PHP.
        Vi bygger också ett ramverk, Anax lite, något som den här sidan är gjord av. Sidan kommer
        uppdateras, förändras och förbättras ju längre in i kursen vi kommer.</p>
    <p>För att styla hemsidan har jag valt att använda, <a href="http://getpreboot.com/">Preboot</a>,
        ett bra bas-system som innehåller ett antal LESS-mixins och variabler.
        Detta ger mig en standig grund men samtidigt en väldigt stor frihet att göra precis som jag
        själv känner för.</p>
    <blockquote><span>Preboot is a comprehensive and flexible collection of LESS
        utilities. Its original variables and mixins became the precursor to
        Bootstrap. Since then, it's all come full circle.</span></blockquote>
    <figure class="figure">
        <img src="image/php-logo.png?w=250" alt="PHP logo">
    </figure>
</div>
<div class="col-4">
    <h2>Länkar</h2>
    <ul>
        <li><a href="https://github.com/oenstrom/anax-lite">Anax lite på GitHub</a></li>
        <li><a href="<?= $app->url->create("../../kmom01/guess") ?>">Guess the number</a></li>
        <li><a href="<?= $app->url->create("status") ?>">Serverinfo (JSON)</a></li>
    </ul>
</div>
