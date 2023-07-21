# URL del repositorio
$repoUrl = "https://github.com/snakepatch53/chicho_henandez_odontologia.git"
$proyectName = "chicho_henandez_odontologia"

# Detectar la ubicación de la carpeta www o htdocs según el servidor instalado
if (Test-Path "C:\wamp\www") {
    $webRoot = "C:\wamp\www"
} elseif (Test-Path "C:\wamp64\www") {
    $webRoot = "C:\wamp64\www"
} elseif (Test-Path "C:\xampp\htdocs") {
    $webRoot = "C:\xampp\htdocs"
} else {
    Write-Host "No se pudo detectar la ubicación de la carpeta de servidor web." -ForegroundColor Red
    exit
}

# Clonar el repositorio en la carpeta correspondiente
if (Test-Path "$webRoot\$proyectName") {
    Write-Host "Actualizanco cambios..." -ForegroundColor Green
    cd $webRoot
    git pull
    Write-Host "Repositorio actualizado exitosamente en $webRoot" -ForegroundColor Green
} else {
    if (Test-Path $webRoot) {
        Write-Host "Clonando el repositorio en la carpeta de servidor web..." -ForegroundColor Green
        cd $webRoot
        git clone $repoUrl
        Write-Host "Repositorio clonado exitosamente en $webRoot" -ForegroundColor Green
    } else {
        Write-Host "No se pudo detectar la ubicación de la carpeta de servidor web." -ForegroundColor Red
        Write-Host "En ese caso clonaremos en tu disco C:\" -ForegroundColor Green
        cd C:\
        git clone $repoUrl
        exit
    }
}


$HTTP_DOMAIN = Read-Host "Ingresa el HTTP_DOMAIN de la base de datos"
$DB_HOST = Read-Host "Ingresa el DB_HOST de la base de datos"
$DB_USER = Read-Host "Ingresa el DB_USER de la base de datos"
$DB_PASS = Read-Host "Ingresa el DB_PASS de la base de datos"
$DB_NAME = Read-Host "Ingresa el DB_NAME de la base de datos"
$DB_PORT = Read-Host "Ingresa el DB_PORT de la base de datos"

$ENV = ""
$ENV += "HTTP_DOMAIN=$HTTP_DOMAIN`r`n"
$ENV += "DB_HOST = $DB_HOST`r`n"
$ENV += "DB_USER = $DB_USER`r`n"
$ENV += "DB_PASS = $DB_PASS`r`n"
$ENV += "DB_NAME = $DB_NAME`r`n"
$ENV += "DB_PORT = $DB_PORT`r`n"

$ENV | Out-File -FilePath .env