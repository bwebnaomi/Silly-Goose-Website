#!/usr/bin/env python3
"""
Silly Goose Theme Deployment Script
Cleans up server structure and uploads optimized files
"""

import ftplib
import os
import sys
from getpass import getpass

# FTP Configuration
HOST = "46.202.192.173"
USER = "u718531379.sillygoose"
PORT = 21

# Files to upload
FILES_TO_UPLOAD = [
    "wp-content/themes/SillyGoose/functions.php",
    "wp-content/themes/SillyGoose/header.php",
    "wp-content/themes/SillyGoose/footer.php",
    "wp-content/themes/SillyGoose/style.css",
    "wp-content/themes/SillyGoose/style.min.css",
    "wp-content/themes/SillyGoose/css/custom-blocks.css",
    "wp-content/themes/SillyGoose/css/custom-blocks.min.css",
    "wp-content/themes/SillyGoose/js/theme.js",
    "wp-content/themes/SillyGoose/js/theme.min.js",
]

def connect_ftp(password):
    """Connect to FTP server"""
    print(f"Connecting to {HOST}...")
    ftp = ftplib.FTP()
    ftp.connect(HOST, PORT)
    ftp.login(USER, password)
    print(f"✓ Connected as {USER}")
    return ftp

def check_structure(ftp):
    """Check and display server structure"""
    print("\n" + "="*50)
    print("Checking Server Structure")
    print("="*50)

    print("\n1. FTP Root Directory:")
    try:
        ftp.cwd('/')
        print(f"   Current: {ftp.pwd()}")
        items = []
        ftp.retrlines('LIST', items.append)
        for item in items[:10]:  # Show first 10 items
            print(f"   {item}")
    except Exception as e:
        print(f"   Error: {e}")

    print("\n2. public_html Directory:")
    try:
        ftp.cwd('/public_html')
        print(f"   Current: {ftp.pwd()}")
        items = []
        ftp.retrlines('LIST', items.append)
        for item in items[:10]:
            print(f"   {item}")
    except Exception as e:
        print(f"   Error: {e}")

    print("\n3. WordPress wp-content Directory:")
    try:
        ftp.cwd('/public_html/wp-content/themes/SillyGoose')
        print(f"   Current: {ftp.pwd()}")
        items = []
        ftp.retrlines('LIST', items.append)
        print(f"   Found {len(items)} items in SillyGoose theme folder")
    except Exception as e:
        print(f"   Error: {e}")

def upload_file(ftp, local_path, remote_path):
    """Upload a single file"""
    try:
        with open(local_path, 'rb') as f:
            ftp.storbinary(f'STOR {remote_path}', f)
        size = os.path.getsize(local_path)
        print(f"   ✓ {os.path.basename(local_path)} ({size:,} bytes)")
        return True
    except Exception as e:
        print(f"   ✗ {os.path.basename(local_path)} - Error: {e}")
        return False

def upload_files(ftp):
    """Upload all optimized theme files"""
    print("\n" + "="*50)
    print("Uploading Optimized Theme Files")
    print("="*50 + "\n")

    success_count = 0
    fail_count = 0

    for local_file in FILES_TO_UPLOAD:
        if not os.path.exists(local_file):
            print(f"   ⚠ {local_file} - File not found locally")
            fail_count += 1
            continue

        # Construct remote path
        remote_file = "/public_html/" + local_file

        # Ensure directory exists
        remote_dir = os.path.dirname(remote_file)
        try:
            ftp.cwd(remote_dir)
        except:
            print(f"   Creating directory: {remote_dir}")
            # Create directories recursively
            parts = remote_dir.split('/')
            current = ""
            for part in parts:
                if not part:
                    continue
                current += "/" + part
                try:
                    ftp.cwd(current)
                except:
                    try:
                        ftp.mkd(current)
                        ftp.cwd(current)
                    except:
                        pass

        # Upload file
        if upload_file(ftp, local_file, os.path.basename(remote_file)):
            success_count += 1
        else:
            fail_count += 1

    print("\n" + "="*50)
    print(f"Upload Summary: {success_count} succeeded, {fail_count} failed")
    print("="*50)

def main():
    """Main deployment function"""
    print("\n" + "="*50)
    print("Silly Goose Theme Deployment Script")
    print("="*50 + "\n")

    # Get password
    password = getpass("Enter FTP password: ")

    if not password:
        print("Error: Password is required")
        sys.exit(1)

    try:
        # Connect to FTP
        ftp = connect_ftp(password)

        # Check structure
        check_structure(ftp)

        # Ask for confirmation
        print("\n" + "="*50)
        response = input("Proceed with file upload? (y/n): ")
        if response.lower() != 'y':
            print("Deployment cancelled.")
            ftp.quit()
            return

        # Upload files
        upload_files(ftp)

        # Close connection
        ftp.quit()

        print("\n✓ Deployment Complete!")
        print("\nCheck your website:")
        print("https://powderblue-crab-538553.hostingersite.com/")

    except ftplib.error_perm as e:
        print(f"\n✗ FTP Permission Error: {e}")
        print("Please check your username and password.")
        sys.exit(1)
    except Exception as e:
        print(f"\n✗ Error: {e}")
        sys.exit(1)

if __name__ == "__main__":
    main()