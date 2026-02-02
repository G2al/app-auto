# AppAuto

Sistema di gestione auto con interfaccia amministrativa avanzata.

## 🚗 Descrizione

AppAuto è un'applicazione Laravel per la gestione di veicoli, con funzionalità complete per:
- Gestione inventario auto
- Tracking costi e prezzi
- Generazione documenti PDF
- Interfaccia admin con Filament
- Import/Export dati Excel/CSV
- Dashboard avanzata con widget personalizzati

## 🛠 Requisiti di Sistema

- **PHP**: 8.2 o superiore
- **MySQL**: 8.0 o superiore
- **Node.js**: 18 o superiore
- **Composer**: 2.x
- **XAMPP/WAMP** (per sviluppo locale)

## 🚀 Tecnologie Utilizzate

### Backend
- **Laravel**: 12.19.3 (Framework principale)
- **Filament**: 3.3.28 (Admin Panel)
- **Livewire**: 3.6.3 (Componenti dinamici)

### Plugin Filament
- **Filament Advanced Widgets**: 3.0.1 (Widget dashboard avanzati)

### Database & Query
- **MySQL**: Database principale
- **Doctrine DBAL**: Operazioni database avanzate
- **Eloquent Power Joins**: Join ottimizzati

### Documenti & File
- **DomPDF**: Generazione PDF
- **OpenSpout**: Gestione Excel/ODS
- **League CSV**: Import/Export CSV

### UI & Frontend
- **Blade Heroicons**: Set di icone
- **Tailwind CSS**: Styling (via Filament)

### Development Tools
- **Laravel Pail**: Log viewer
- **Laravel Pint**: Code formatter
- **Laravel Tinker**: REPL/Console
- **PHPUnit**: Testing framework

## 📦 Installazione

1. **Clona il repository**
   ```bash
   git clone [url-repository]
   cd appauto
   ```

2. **Installa dipendenze PHP**
   ```bash
   composer install
   ```

3. **Installa dipendenze Node.js**
   ```bash
   npm install
   ```

4. **Configura l'ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configura database nel file `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=appauto
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Esegui migrazioni**
   ```bash
   php artisan migrate
   ```

7. **Crea utente admin Filament**
   ```bash
   php artisan make:filament-user
   ```

8. **Genera dati di esempio (opzionale)**
   ```bash
   php artisan tinker
   App\Models\Vehicle::factory(30)->create();
   ```

9. **Avvia il server**
   ```bash
   php artisan serve
   ```

## 📊 Plugin Advanced Widgets

Il progetto utilizza il plugin `eightynine/filament-advanced-widgets` per widget dashboard avanzati.

### Installazione Plugin

Il plugin è già incluso nelle dipendenze del progetto e verrà installato automaticamente con `composer install`. 

Se necessario, puoi installarlo manualmente:
```bash
composer require eightynine/filament-advanced-widgets
```

### Widget Disponibili

1. **Advanced Stats Overview Widget**
   - Statistiche avanzate con icone, progress bar e personalizzazioni
   - Utilizzato in: `VehicleStatsWidget`

2. **Advanced Chart Widget**
   - Grafici personalizzabili con badge, icone e filtri
   - Utilizzato in: `FatturatoChartWidget`, `FatturatoAnnualeWidget`

3. **Advanced Table Widget**
   - Tabelle avanzate (work in progress nel plugin)
   - Utilizzato in: `UltimiVeicoliWidget` (usando widget standard Filament)

### Creazione Nuovi Widget

Per creare un nuovo widget avanzato:

```bash
# Stats Overview Widget
php artisan make:filament-advanced-widget NomeWidget --advanced-stats-overview

# Chart Widget
php artisan make:filament-advanced-widget NomeWidget --advanced-chart
```

## 🎯 Utilizzo

### Accesso Admin Panel
- URL: `http://localhost:8000/admin`
- Login con le credenziali create al punto 7

### Funzionalità Principali
- **Gestione Veicoli**: CRUD completo con factory per dati test
- **Dashboard Avanzata**: Widget statistiche, grafici fatturato mensile/annuale
- **Documenti PDF**: Generazione automatica documenti
- **Import/Export**: Excel e CSV supportati
- **Ricerca Avanzata**: Filtri multipli

### Widget Dashboard
- **Statistiche Veicoli**: Totale, Disponibili, Venduti, Archiviati
- **Fatturato Mensile**: Grafico interattivo con filtri temporali
- **Fatturato Annuale**: Confronto performance annuale
- **Ultimi Veicoli**: Tabella con ultimi inserimenti

## 🗂 Struttura Database

### Tabelle Principali
- `vehicles` - Dati veicoli (marca, modello, prezzo, ecc.)
- `vehicle_documents` - Documenti associati
- `users` - Utenti sistema
- `sessions` - Sessioni utente

## 🔧 Comandi Utili

```bash
# Pulire cache
php artisan cache:clear
php artisan config:clear

# Visualizzare log
php artisan pail

# Accesso console
php artisan tinker

# Formattare codice
./vendor/bin/pint

# Eseguire test
php artisan test
```

## 📝 Note di Sviluppo

- Utilizzare **Factory** per generare dati di test
- **Filament** per tutte le operazioni CRUD admin
- **Livewire** per componenti interattivi
- **DomPDF** per report e documenti
- **Advanced Widgets** per dashboard personalizzate

## 🐛 Troubleshooting

### Errori Database
```bash
php artisan migrate:fresh --seed
```

### Problemi Cache
```bash
php artisan optimize:clear
```

### Errori Filament
```bash
php artisan filament:optimize
```

### Problemi Widget
```bash
# Pulire cache view
php artisan view:clear

# Ricompilare assets
npm run build
```

## 📄 Licenza

Questo progetto è rilasciato sotto licenza MIT.