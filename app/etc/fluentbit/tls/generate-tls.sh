#!/bin/bash
DAYS=3650
PASS=$(openssl rand -hex 16)

rm -rf *.pem

# Create CA certificate
openssl genrsa -des3 -passout pass:$PASS -out ca-key.pem 2048
openssl req -subj '/CN=*/' -new -x509 -days $DAYS -passin pass:$PASS -key ca-key.pem -out ca.pem

# Create server certificate, remove passphrase, and sign it
# server-cert.pem = public key, server-key.pem = private key
openssl req -subj '/CN=*/' -newkey rsa:2048 -days $DAYS -nodes -keyout server-key.pem -out server-req.pem
openssl rsa -in server-key.pem -out server-key.pem
openssl x509 -req -in server-req.pem -days $DAYS -passin pass:$PASS -CA ca.pem -CAkey ca-key.pem -set_serial 01 -out server-cert.pem

# Create client certificate, remove passphrase, and sign it
# client-cert.pem = public key, client-key.pem = private key
openssl req -subj '/CN=*/' -newkey rsa:2048 -days $DAYS -nodes -keyout client-key.pem -out client-req.pem
openssl rsa -in client-key.pem -out client-key.pem
openssl x509 -req -in client-req.pem -days $DAYS -passin pass:$PASS -CA ca.pem -CAkey ca-key.pem -set_serial 01 -out client-cert.pem

echo ""
echo ""
echo "=========="
echo "Certificate genreated and password is $PASS"
