<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;




class ContactDto
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    public string $name = '';

    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    public string $email = '';

    #[Assert\Length(min: 10, max: 300)]
    #[Assert\NotBlank]
    public string $content = '';
}
