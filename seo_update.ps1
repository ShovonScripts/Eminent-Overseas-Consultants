$dir = "c:\xampp\htdocs\eminent"
$files = Get-ChildItem -Path $dir -Include *.html, *.php -Recurse -File | Where-Object { $_.Name -ne "index.html" -and $_.Name -ne "send_email.php" }

foreach ($file in $files) {
    $content = [System.IO.File]::ReadAllText($file.FullName)
    $modified = $false

    # Update or insert og:image
    if ($content -match '<meta property="og:image"[^>]*>') {
        $content = $content -replace '<meta property="og:image"[^>]*>', '<meta property="og:image" content="https://eminentoverseas.uk/images/hero-banner-1.jpg">'
        $modified = $true
    } else {
        # Insert after og:description if it exists
        if ($content -match '<meta property="og:description"[^>]*>') {
            $content = $content -replace '(<meta property="og:description"[^>]*>)', "`$1`n  <meta property=`"og:image`" content=`"https://eminentoverseas.uk/images/hero-banner-1.jpg`">"
            $modified = $true
        }
    }

    # Update or insert twitter:image
    if ($content -match '<meta name="twitter:image"[^>]*>') {
        $content = $content -replace '<meta name="twitter:image"[^>]*>', '<meta name="twitter:image" content="https://eminentoverseas.uk/images/hero-banner-1.jpg">'
        $modified = $true
    } else {
        # Insert after twitter:description if it exists
        if ($content -match '<meta name="twitter:description"[^>]*>') {
            $content = $content -replace '(<meta name="twitter:description"[^>]*>)', "`$1`n  <meta name=`"twitter:image`" content=`"https://eminentoverseas.uk/images/hero-banner-1.jpg`">"
            $modified = $true
        }
    }

    if ($modified) {
        [System.IO.File]::WriteAllText($file.FullName, $content)
        Write-Host "Updated $($file.Name)"
    }
}
Write-Host "SEO social images update complete."
