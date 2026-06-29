<?php

if(mail(
    "info.caringsquad@gmail.com",
    "Test Mail",
    "This is a test email.",
    "From: support@caringsquad.in"
))
{
    echo "Mail Sent";
}
else
{
    echo "Mail Failed";
}

?>