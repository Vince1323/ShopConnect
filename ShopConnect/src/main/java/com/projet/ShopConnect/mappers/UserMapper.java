package com.projet.ShopConnect.mappers;

import com.projet.ShopConnect.dtos.SignUpDto;
import com.projet.ShopConnect.dtos.UserDto;
import com.projet.ShopConnect.model.User;
import com.projet.ShopConnect.model.User;
import org.mapstruct.Mapper;
import org.mapstruct.Mapping;

@Mapper(componentModel = "spring")
public interface UserMapper {

    UserDto toUserDto(User user);

    @Mapping(target = "password", ignore = true)
    User signUpToUser(SignUpDto signUpDto);

}
