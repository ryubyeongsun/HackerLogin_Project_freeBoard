
  document.addEventListener("DOMContentLoaded", () =>{
   //아이디 중복체크
    const btn_id_check = document.querySelector("#btn_id_check")
    btn_id_check.addEventListener("click", ()=>{

      const f_id = document.querySelector("#f_id")
      if(f_id.value == ''){
        alert('아이디를 입력해 주세요.')
        return false
      }

      // AJAX
      const f1 = new FormData()
      f1.append('id', f_id.value)
      f1.append('mode', 'id_chk')

      const xhr = new XMLHttpRequest()
      xhr.open("POST", "./pg/member_process.php","true")
      xhr.send(f1)

      xhr.onload = () => {
        if(xhr.status == 200){
          const data = JSON.parse(xhr.responseText)
          if(data.result == 'success'){
            alert('사용이 가능한 아이디입니다.')
            document.input_form.id_chk.value = "1"
          }else if(data.result == 'fail'){
            document.input_form.id_chk.value = "0"
            alert('이미 사용중인 아이디입니다. 다른 아이디를 입력해 주세요.')
            f_id.value=''
            f_id.focus()
          } else if(data.result == 'empty_id'){
            alert('아이디가 비어 있습니다.')
            f_id.focus()
          }
        }
      }
    })

    //이메일 중복체크
    const btn_email_check = document.querySelector("#btn_email_check")
    btn_email_check.addEventListener("click", ()=>{

      const f_email = document.querySelector("#f_email")
      if(f_email.value == ''){
        alert('이메일을 입력해 주세요.')
        f_email.focus()
        return false
      }

      // AJAX
      const f1 = new FormData()
      f1.append('email', f_email.value)
      f1.append('mode', 'email_chk')

      const xhr = new XMLHttpRequest()
      xhr.open("POST", "./pg/member_process.php","true")
      xhr.send(f1)

      xhr.onload = () => {
        if(xhr.status == 200){
          const data = JSON.parse(xhr.responseText)
          if(data.result == 'success'){
            alert('사용이 가능한 이메일입니다.')
            document.input_form.email_chk.value = "1"
          }else if(data.result == 'fail'){
            document.input_form.email_chk.value = "0"
            alert('이미 사용중인 이메일입니다. 다른 이메일를 입력해 주세요.')
            f_email.value=''
            f_email.focus()
          } else if(data.result == 'empty_email'){
            alert('이메일가 비어 있습니다.')
            f_email.focus()
          }else if(data.result == 'email_format_wrong'){
            alert('이메일이 형식에 맞지 않습니다.')
            f_email.value=''
            f_email.focus()
          }
        }
      }
    })

    //가입 버튼 클릭시
    const btn_submit=document.querySelector("#btn_submit")
    btn_submit.addEventListener("click",() => {
      const f = document.input_form
      if(f.id.value==''){
        alert('아이디를 입력해 주세요.')
        f.id.focus()
        return false
      }
      //아이디 중복확인 여부 체크
      if(f.id_chk.value==0){
        alert('아이디 중복확인을 해주시기 바랍니다.')
        return false
      }
      //이름 입력 확인
      if(f.name.value==''){
        alert('이름을 입력해 주세요.')
        f.name.focus()
        return false
      }

      //비밀번호 확인
      if(f.password.value==''){
        alert('비밀번호를 입력해 주세요.')
        f.password.focus()
        return false
      }

      if(f.password2.value==''){
        alert('확인용 비밀번호를 입력해 주세요.')
        f.password2.focus()
        return false
      }

      if(f.password.value != f.password2.value){
        alert('비밀번호가 서로 일치하지 않습니다.')
        f.password.value=''
        f.password2.value=''
        f.password.focus()
        return false
      }
      //이메일 입력 부분 확인
      if(f.email.value == ''){
        alert('이메일을 입력해 주세요.')
         f.email.focus()
         return false
      }
      //이메일 중복 체크 여부 확인
      if(f.email_chk.value == 0){
        alert('이메일 중복확인을 해주세요.')
        return false
      }
      f.submit()
    })
  })