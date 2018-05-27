#!/bin/bash
RANDOMAASAAMPASSWORD=$(openssl rand -base64 32 | tr -cd '[[:alnum:]]._-' | cut -c1-16) \
  && echo $RANDOMAASAAMPASSWORD > /tmp/aaa && echo "aasaam:$RANDOMAASAAMPASSWORD" | chpasswd && echo "New password for aasaam is `$RANDOMAASAAMPASSWORD`"