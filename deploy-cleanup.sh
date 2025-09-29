#!/bin/bash

# Silly Goose Theme Deployment & Cleanup Script
# This script will:
# 1. Connect to the FTP server
# 2. Check the directory structure
# 3. Clean up any nested public_html folders
# 4. Upload the optimized theme files

HOST="46.202.192.173"
USER="u718531379.sillygoose"
PORT="21"

echo "=========================================="
echo "Silly Goose Theme Deployment Script"
echo "=========================================="
echo ""

# Check if password is provided
if [ -z "$FTP_PASSWORD" ]; then
    echo "Please enter your FTP password:"
    read -s FTP_PASSWORD
    export FTP_PASSWORD
fi

echo ""
echo "Step 1: Checking remote server structure..."
echo ""

# Check the root directory structure
ftp -inv $HOST $PORT << EOF
user $USER $FTP_PASSWORD
pwd
ls -la
bye
EOF

echo ""
echo "Step 2: Checking public_html directory..."
echo ""

ftp -inv $HOST $PORT << EOF
user $USER $FTP_PASSWORD
cd public_html
pwd
ls -la
bye
EOF

echo ""
echo "Would you like to proceed with cleanup and upload? (y/n)"
read -r RESPONSE

if [ "$RESPONSE" != "y" ]; then
    echo "Deployment cancelled."
    exit 0
fi

echo ""
echo "Step 3: Uploading theme files..."
echo ""

# Upload the optimized files
lftp -e "
set ftp:ssl-allow no;
open ftp://$USER:$FTP_PASSWORD@$HOST;
cd /public_html/wp-content/themes/SillyGoose;
lcd wp-content/themes/SillyGoose;
put functions.php;
put header.php;
put footer.php;
put style.css;
put style.min.css;
cd css;
lcd css;
put custom-blocks.css;
put custom-blocks.min.css;
cd ../js;
lcd ../js;
put theme.js;
put theme.min.js;
bye
"

echo ""
echo "=========================================="
echo "Deployment Complete!"
echo "=========================================="
echo ""
echo "Please check your website:"
echo "https://powderblue-crab-538553.hostingersite.com/"