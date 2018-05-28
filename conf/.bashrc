if [ "$SSH_USER" == "" ]; then
  export SSH_USER="host-docker"
fi
export LANG=en_US.utf8
export LC_ALL=C.UTF-8
export LS_OPTIONS='--color=auto'
export TERM=xterm
export HISTFILE="$HOME/.history_$SSH_USER"
HISTFILESIZE=1000
HISTSIZE=1000
alias ll='ls $LS_OPTIONS -la'
if [ -f /etc/bash_completion ] && ! shopt -oq posix; then
  . /etc/bash_completion
fi
export PS1="\[\033[38;5;3m\]\u\[$(tput sgr0)\]\[\033[38;5;8m\]@\[$(tput sgr0)\]\[\033[38;5;5m\]\h\[$(tput sgr0)\]\[\033[38;5;8m\]:\[$(tput sgr0)\]\[\033[38;5;244m\]\w\[$(tput bold)\]\[$(tput sgr0)\]\[\033[38;5;43m\]\\$\[$(tput sgr0)\]\[$(tput sgr0)\]\[\033[38;5;15m\] \[$(tput sgr0)\]"
resize > /dev/null
