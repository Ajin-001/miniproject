<fieldset>
      <legend><b>Pet Information:</b></legend>
      Name of Pet:<br>
      <input type="text" name="petname">
      <br><br>
      Gender:<br><br>
      <input type="radio" name="gender" value="Male">Male<br><br>
      <input type="radio" name="gender" value="Female">Female<br>
      <br>
      Age:<br>
      <input type="number" name="age">
      <br><br>
      Type:<br>
      <select name="type">
        <option value="Cat" name="type" id="cat">Cat</option>
        <option value="Dog" name="type" id="dog">Dog</option>
      </select>
      <br><br>
      Breed:<br>
      <select name="breed">
        <option value="American Bobtail" name="breed">American Bobtail</option>
        <option value="German Shepherd">German Shephard</option>
        <option value="Golden Retriever">Golden Retriever</option>
        <option value="Indian Pariah">Indian Pariah</option>
        <option value="Maine Coon">Maine Coon</option>
        <option value="Persian">Persian</option>
        <option value="Pugs">Pugs</option>
        <option value="Rottweiler">Rottweiler</option>
        <option value="Saint Bernard">Saint Bernard</option>
        <option value="Siamese">Siamese</option>
      </select>
      <br><br>
    </fieldset>

    $sql = "INSERT INTO pet_info(Name,gender,age,type,breed,username) VALUES('$petname','$gender','$age','$type','$breed','$username')";
  $result = mysqli_query($conn,$sql);
  session_start();