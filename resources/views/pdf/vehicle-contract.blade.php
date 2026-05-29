@php
    $field = function ($value, ?int $max = null) {
        $value = filled($value) ? trim((string) $value) : '';

        if ($value === '') {
            return '&nbsp;';
        }

        if ($max !== null && function_exists('mb_strlen') && mb_strlen($value) > $max) {
            $value = mb_substr($value, 0, $max);
        }

        return e($value);
    };

    $date = fn ($value) => $value ? $value->format('d/m/Y') : '&nbsp;';
    $customerFullName = trim(($vehicle->customer_name ?? '') . ' ' . ($vehicle->customer_surname ?? ''));
@endphp
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0; }

        body {
            margin: 0;
            color: #000;
            font-family: "Times New Roman", Times, serif;
        }

        .page {
            width: 210mm;
            height: 297mm;
            page-break-after: always;
            position: relative;
            overflow: hidden;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .sheet {
            width: 162mm;
            margin: 0 auto;
        }

        .proposal {
            padding-top: 30mm;
            font-size: 14px;
            line-height: 1.80;
        }

        .conditions {
            padding-top: 25mm;
            font-size: 11.3px;
            line-height: 1.03;
        }

        h1 {
            margin: 0 0 8mm;
            text-align: center;
            font-size: 14px;
            line-height: 1.08;
            font-weight: bold;
        }

        h2 {
            margin: 0 0 7mm;
            text-align: center;
            font-size: 12px;
            line-height: 1.08;
            font-weight: bold;
        }

        p {
            margin: 0 0 4.2mm;
        }

        .conditions p {
            margin: 0 0 1mm;
        }

        .heading-label {
            display: block;
            font-size: 15px;
            line-height: 1;
            font-weight: bold;
        }

        .section-title {
            margin: 7mm 0 1.4mm;
            font-weight: bold;
            font-size: 14px;
        }

        .proposal .section-title.compact {
            margin-top: 2.6mm;
        }

        .conditions .section-title {
            margin: 1.3mm 0 0;
            font-size: 11.3px;
        }

        .line {
            white-space: nowrap;
        }

        .proposal .line {
            line-height: 1.34;
        }

        .justify {
            text-align: justify;
        }

        .field,
        .manual {
            display: inline-block;
            height: 14px;
            line-height: 13px;
            border-bottom: 1px dotted #000;
            vertical-align: baseline;
        }

        .proposal .field,
        .proposal .manual {
            height: 16px;
            line-height: 15px;
        }

        .field {
            padding: 0 2px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            font-size: 12.4px;
        }

        .manual {
            vertical-align: -1px;
        }

        .w24 { width: 24px; }
        .w46 { width: 46px; }
        .w58 { width: 58px; }
        .w62 { width: 62px; }
        .w70 { width: 70px; }
        .w74 { width: 74px; }
        .w78 { width: 78px; }
        .w82 { width: 82px; }
        .w88 { width: 88px; }
        .w92 { width: 92px; }
        .w96 { width: 96px; }
        .w104 { width: 104px; }
        .w112 { width: 112px; }
        .w118 { width: 118px; }
        .w126 { width: 126px; }
        .w138 { width: 138px; }
        .w150 { width: 150px; }
        .w166 { width: 166px; }
        .w184 { width: 184px; }
        .w220 { width: 220px; }

        .box {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid #000;
            margin: 0 3px;
            vertical-align: -1px;
        }

        .place {
            margin-top: 7mm;
            font-weight: bold;
        }

        .signatures {
            width: 100%;
            margin-top: 7mm;
            border-collapse: collapse;
        }

        .signatures td {
            width: 50%;
            font-weight: bold;
            font-size: 12.3px;
        }

        .signatures td:first-child {
            text-align: left;
        }

        .signatures td:last-child {
            text-align: right;
        }

        .sign-line {
            display: inline-block;
            width: 52mm;
            height: 6mm;
            border-bottom: 1px solid #000;
        }

        .conditions .place {
            margin-top: 9mm;
            font-size: 13px;
        }

        .conditions .signatures {
            margin-top: 7mm;
        }

        .approval {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
@for ($copy = 1; $copy <= 2; $copy++)
    <div class="page">
        <div class="sheet proposal">
            <h1>PROPOSTA DI ACQUISTO E CONTRATTO DI VENDITA DI<br>AUTOVEICOLO USATO</h1>

            <p>
                <span class="heading-label">VENDITORE:</span>
                AUTOCCASIONE PEZONE s.r.l.s., con sede legale in San Marcellino (CE), Via Messina n. 18, C.F. e P.IVA 04119090613, in persona del legale rappresentante <em>pro tempore</em> (di seguito "Venditore")
            </p>

            <p>
                <span class="heading-label">ACQUIRENTE:</span>
                <span class="line">Sig./Sig.ra <span class="field w126">{!! $field($customerFullName, 24) !!}</span>, nato/a a <span class="field w118">{!! $field($vehicle->customer_birth_place, 20) !!}</span> il <span class="field w78">{!! $date($vehicle->customer_birth_date) !!}</span>,</span><br>
                <span class="line">C.F. <span class="field w138">{!! $field($vehicle->customer_fiscal_code, 22) !!}</span>, residente in <span class="field w104">{!! $field($vehicle->customer_residence_city, 18) !!}</span>, Via <span class="field w104">{!! $field($vehicle->customer_address, 20) !!}</span></span><br>
                <span class="line">n. <span class="field w24">{!! $field($vehicle->customer_street_number, 5) !!}</span>, Tel. <span class="field w112">{!! $field($vehicle->phone_number, 18) !!}</span>, email <span class="field w150">{!! $field($vehicle->customer_email, 28) !!}</span> (di seguito "Acquirente")</span>
            </p>

            <p class="section-title">Art. 1 - Oggetto del Contratto</p>
            <p class="justify">
                L'Acquirente propone di acquistare e, con l'accettazione del Venditore, acquista la piena ed esclusiva propriet&agrave; del seguente autoveicolo usato, alle condizioni particolari di seguito specificate e alle Condizioni Generali di Contratto riportate in calce, che dichiara di aver letto e di accettare integralmente.
            </p>

            <p>
                <span class="line">Marca: <span class="field w104">{!! $field($vehicle->brand_model, 18) !!}</span> Modello: <span class="field w126">{!! $field($vehicle->brand_model, 22) !!}</span> Targa: <span class="field w82">{!! $field($vehicle->license_plate, 12) !!}</span> Numero di Telaio</span><br>
                <span class="line">(VIN): <span class="field w138">{!! $field($vehicle->chassis, 24) !!}</span> Data di 1&ordf; Immatricolazione: <span class="field w88">{!! $field($vehicle->registration_year, 14) !!}</span></span><br>
                <span class="line">Chilometraggio indicato: <span class="field w118">{!! $field($vehicle->km, 12) !!}</span> Km Colore: <span class="field w126">{!! $field($vehicle->color, 20) !!}</span></span><br>
                <span class="line">Ultima revisione: <span class="field w112">{!! $date($vehicle->last_revision_date) !!}</span> Dotazioni supplementari: <span class="field w150">{!! $field($vehicle->additional_equipment, 28) !!}</span></span><br>
                <span class="line"><span class="field w138">&nbsp;</span> Documenti da consegnare: Libretto di circolazione, Certificato</span><br>
                <span>di Propriet&agrave; Digitale (CDPD), libretto uso e manutenzione, n. 2 chiavi.</span>
            </p>

            <p class="section-title">Art. 2 - Prezzo e Modalit&agrave; di Pagamento</p>
            <p>
                <strong>2.1.</strong> Il prezzo della compravendita &egrave; convenuto in &euro; <span class="manual w104"></span>,.. (Euro <span class="manual w184"></span>/..), IVA inclusa.
            </p>
            <p>
                <strong>2.2.</strong> Il pagamento avverr&agrave; come segue: Acconto alla firma: &euro; <span class="manual w78"></span> * Saldo alla consegna: &euro; <span class="manual w78"></span> mediante <span class="box"></span> contanti (nei limiti di legge) / <span class="box"></span> assegno circolare / <span class="box"></span> bonifico bancario.
            </p>
            <p><strong>2.3.</strong> Le spese relative al trasferimento di propriet&agrave; sono a totale carico dell'Acquirente.</p>

            <p class="section-title compact">Art. 3 - Consegna</p>
            <p>
                La consegna del veicolo &egrave; prevista per il giorno <span class="manual w104"></span> presso la sede del Venditore, previo saldo integrale del prezzo.
            </p>

            <p class="place">San Marcellino (CE) <span class="manual w118"></span></p>

            <table class="signatures">
                <tr>
                    <td>Firma dell'Acquirente<br><span class="sign-line"></span></td>
                    <td>Per accettazione del Venditore<br><span class="sign-line"></span></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="page">
        <div class="sheet conditions">
            <h2>CONDIZIONI GENERALI DI CONTRATTO</h2>

            <p class="section-title">Art. 1 - Stato del Veicolo, Usura e Clausola "Visto e Piaciuto"</p>
            <p>1.1. L'Acquirente d&agrave; atto di aver ispezionato il veicolo, anche con l'assistenza di un tecnico di propria fiducia, e di averlo provato su strada, accettandolo nello stato di fatto e di diritto in cui si trova.</p>
            <p>1.2. L'Acquirente &egrave; consapevole e accetta che, trattandosi di un bene usato, la conformit&agrave; dello stesso debba essere valutata "tenuto conto del tempo del pregresso utilizzo" (art. 128, co. 5, Cod. Consumo). L'Acquirente riconosce che il veicolo &egrave; composto da parti meccaniche, elettriche ed elettroniche soggette a usura progressiva, la cui vita utile residua &egrave; intrinsecamente inferiore a quella di un veicolo nuovo.</p>
            <p>1.3. Di conseguenza, il guasto o la rottura di un componente che si verifichi durante il periodo di garanzia non costituisce un difetto di conformit&agrave; qualora sia riconducibile alla normale e prevedibile usura del componente stesso, in considerazione dell'et&agrave;, del chilometraggio e della manutenzione pregressa del veicolo. Tali eventi sono da considerarsi come naturale conseguenza del pregresso utilizzo del bene e non come vizi occulti preesistenti.</p>
            <p>1.4. La vendita &egrave; regolata dalla clausola "visto e piaciuto". Tale clausola esonera il Venditore dalla garanzia per i vizi palesi o facilmente riconoscibili con l'uso dell'ordinaria diligenza al momento della consegna. La clausola non opera per i vizi occulti che non siano conseguenza della normale usura e per quelli che il Venditore abbia in mala fede taciuto.</p>

            <p class="section-title">Art. 2 - Garanzia Legale di Conformit&agrave; (Durata Ridotta)</p>
            <p>2.1. Fatto salvo quanto previsto all'art. 1, il Venditore presta la garanzia legale di conformit&agrave; per i difetti preesistenti alla consegna, ai sensi degli artt. 129 e ss. del D.Lgs. 206/2005.</p>
            <p>2.2. Le parti, in considerazione della vetust&agrave; e dello stato d'uso del veicolo, concordano espressamente, a seguito di specifica trattativa individuale, di ridurre la durata della responsabilit&agrave; del Venditore a dodici (12) mesi dalla data di consegna, ai sensi dell'art. 134, comma 2, del Codice del Consumo.</p>
            <p>2.3. Si presume, salvo prova contraria, che i difetti di conformit&agrave; che si manifestano entro un anno dalla consegna esistessero gi&agrave; a tale data, a meno che tale ipotesi sia incompatibile con la natura del bene o con la natura del difetto di conformit&agrave; (es. usura).</p>

            <p class="section-title">Art. 3 - Esclusioni e Obblighi dell'Acquirente</p>
            <p>3.1. Oltre a quanto previsto all'art. 1.3, la garanzia non &egrave; dovuta per danni causati da uso improprio, negligenza, incidenti, o per la mancata o errata esecuzione della manutenzione ordinaria secondo le prescrizioni della casa costruttrice.</p>
            <p>3.2. L'Acquirente decade dalla garanzia qualora effettui modifiche, manomissioni o riparazioni sul veicolo senza il preventivo consenso scritto del Venditore.</p>

            <p class="section-title">Art. 4 - Denuncia dei Vizi e Rimedi</p>
            <p>4.1. L'Acquirente decade dal diritto alla garanzia se non denuncia il difetto di conformit&agrave; al Venditore entro il termine di due mesi dalla scoperta, mediante comunicazione scritta (raccomandata A/R o PEC).</p>
            <p>4.2. In caso di difetto di conformit&agrave;, l'Acquirente ha diritto in via primaria al ripristino della conformit&agrave; mediante riparazione. Il Venditore si riserva la facolt&agrave; di eseguire la riparazione presso la propria officina o altra di sua fiducia. I rimedi della riduzione del prezzo o della risoluzione del contratto sono esperibili solo nei casi previsti dall'art. 135-bis, comma 4, del Codice del Consumo.</p>

            <p class="section-title">Art. 5 - Foro Competente</p>
            <p>Per qualsiasi controversia &egrave; competente in via esclusiva il foro del luogo di residenza o domicilio elettivo dell'Acquirente, se riveste la qualit&agrave; di consumatore.</p>

            <p class="section-title">Art. 6 - Trattamento dei Dati Personali</p>
            <p>L'Acquirente dichiara di aver ricevuto l'informativa ai sensi dell'art. 13 del Regolamento UE 2016/679 (GDPR) e presta il proprio consenso al trattamento dei dati per le finalit&agrave; contrattuali.</p>

            <p class="section-title">Art. 7 - Rinvio</p>
            <p>Per quanto non previsto, si applicano le norme del Codice Civile e del D.Lgs. 206/2005.</p>

            <p class="approval">Approvazione specifica delle clausole vessatorie</p>
            <p class="approval">L'Acquirente dichiara di aver letto, compreso e di approvare specificamente per iscritto, ai sensi e per gli effetti degli artt. 1341 e 1342 del Codice Civile, le seguenti clausole delle Condizioni Generali di Contratto Art. 1 (Stato del Veicolo, Usura e Clausola "Visto e Piaciuto" - limitazione di responsabilit&agrave; e definizione di non conformit&agrave;); Art. 2 (Garanzia Legale di Conformit&agrave; - Durata Ridotta a 12 mesi); Art. 3 (Esclusioni e Obblighi dell'Acquirente - limitazioni alla facolt&agrave; di opporre eccezioni e decadenze); Art. 4 (Denuncia dei Vizi e Rimedi - decadenza).</p>

            <p class="place">San Marcellino (CE) <span class="manual w118"></span></p>

            <table class="signatures">
                <tr>
                    <td>Firma dell'Acquirente<br><span class="sign-line"></span></td>
                    <td>Per accettazione del Venditore<br><span class="sign-line"></span></td>
                </tr>
            </table>
        </div>
    </div>
@endfor
</body>
</html>
