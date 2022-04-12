FROM fedora

RUN dnf -y install httpd; dnf clean all; systemctl enable httpd

EXPOSE 80

CMD [ "/usr/sbin/init" ]