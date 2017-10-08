export LS_OPTIONS='--color=auto'
export TERM=xterm
alias ll='ls $LS_OPTIONS -la'
if [ -f /etc/bash_completion ] && ! shopt -oq posix; then
  . /etc/bash_completion
fi
