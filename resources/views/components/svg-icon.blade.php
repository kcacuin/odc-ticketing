@props(['name' , 'active'])
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    {{-- * For NAVIGATION --}}
    <symbol id="dashboard" viewBox="0 0 38 35">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.22222 12.2499C3.10242 12.2499 2.02848 11.8812 1.23666 11.2248C0.44484 10.5684 0 9.6782 0 8.74994V3.49994C0 2.57168 0.44484 1.68144 1.23666 1.02507C2.02848 0.368688 3.10242 -6.10352e-05 4.22222 -6.10352e-05H12.6667C13.7865 -6.10352e-05 14.8604 0.368688 15.6522 1.02507C16.444 1.68144 16.8889 2.57168 16.8889 3.49994V8.74994C16.8889 9.6782 16.444 10.5684 15.6522 11.2248C14.8604 11.8812 13.7865 12.2499 12.6667 12.2499H4.22222ZM4.22222 8.74994H12.6667V3.49994H4.22222V8.74994ZM4.22222 34.9999C3.10242 34.9999 2.02848 34.6312 1.23666 33.9748C0.44484 33.3184 0 32.4282 0 31.4999V17.4999C0 16.5717 0.44484 15.6814 1.23666 15.0251C2.02848 14.3687 3.10242 13.9999 4.22222 13.9999H12.6667C13.7865 13.9999 14.8604 14.3687 15.6522 15.0251C16.444 15.6814 16.8889 16.5717 16.8889 17.4999V31.4999C16.8889 32.4282 16.444 33.3184 15.6522 33.9748C14.8604 34.6312 13.7865 34.9999 12.6667 34.9999H4.22222ZM4.22222 31.4999H12.6667V17.4999H4.22222V31.4999ZM21.1111 31.4999C21.1111 32.4282 21.556 33.3184 22.3478 33.9748C23.1396 34.6312 24.2135 34.9999 25.3333 34.9999H33.7778C34.8976 34.9999 35.9715 34.6312 36.7633 33.9748C37.5552 33.3184 38 32.4282 38 31.4999V27.9999C38 27.0717 37.5552 26.1814 36.7633 25.5251C35.9715 24.8687 34.8976 24.4999 33.7778 24.4999H25.3333C24.2135 24.4999 23.1396 24.8687 22.3478 25.5251C21.556 26.1814 21.1111 27.0717 21.1111 27.9999V31.4999ZM33.7778 31.4999H25.3333V27.9999H33.7778V31.4999ZM25.3333 20.9999C24.2135 20.9999 23.1396 20.6312 22.3478 19.9748C21.556 19.3184 21.1111 18.4282 21.1111 17.4999V3.49994C21.1111 2.57168 21.556 1.68144 22.3478 1.02507C23.1396 0.368688 24.2135 -6.10352e-05 25.3333 -6.10352e-05H33.7778C34.8976 -6.10352e-05 35.9715 0.368688 36.7633 1.02507C37.5552 1.68144 38 2.57168 38 3.49994V17.4999C38 18.4282 37.5552 19.3184 36.7633 19.9748C35.9715 20.6312 34.8976 20.9999 33.7778 20.9999H25.3333ZM25.3333 17.4999H33.7778V3.49994H25.3333V17.4999Z" fill="currentColor"/>
    </symbol>
    <symbol id="clients" viewBox="0 0 40 33">
        <path d="M39.4627 19.1675C39.3227 19.2855 39.1633 19.3714 38.9937 19.4202C38.8241 19.469 38.6476 19.4798 38.4743 19.452C38.301 19.4242 38.1342 19.3583 37.9836 19.2581C37.8329 19.1579 37.7013 19.0254 37.5963 18.868C36.7927 17.6547 35.7468 16.6703 34.5427 15.994C33.3386 15.3177 32.0099 14.9684 30.6637 14.9743C30.4015 14.9743 30.1452 14.8874 29.9268 14.7246C29.7083 14.5618 29.5374 14.3302 29.4355 14.0589C29.3663 13.8746 29.3307 13.6767 29.3307 13.4767C29.3307 13.2767 29.3663 13.0788 29.4355 12.8945C29.5374 12.6232 29.7083 12.3916 29.9268 12.2288C30.1452 12.066 30.4015 11.9791 30.6637 11.9791C31.4117 11.979 32.1448 11.7433 32.7795 11.2987C33.4143 10.8541 33.9253 10.2185 34.2546 9.46398C34.5839 8.70949 34.7182 7.86638 34.6423 7.03044C34.5664 6.19449 34.2833 5.39921 33.8252 4.73493C33.3671 4.07065 32.7523 3.564 32.0507 3.27252C31.3491 2.98105 30.5888 2.91643 29.8562 3.08601C29.1236 3.25559 28.4479 3.65257 27.9061 4.23187C27.3642 4.81116 26.9778 5.54954 26.7908 6.36314C26.747 6.55366 26.6703 6.73263 26.565 6.88984C26.4596 7.04704 26.3277 7.1794 26.1769 7.27935C26.026 7.3793 25.8591 7.44489 25.6856 7.47238C25.5122 7.49986 25.3356 7.4887 25.166 7.43954C24.9964 7.39037 24.8371 7.30416 24.6971 7.18583C24.5572 7.06749 24.4394 6.91935 24.3504 6.74987C24.2614 6.58039 24.203 6.39287 24.1785 6.19804C24.1541 6.00321 24.164 5.80487 24.2078 5.61435C24.4673 4.48613 24.9577 3.44153 25.6399 2.56367C26.3221 1.6858 27.1773 0.998911 28.1374 0.557641C29.0975 0.116372 30.1361 -0.0670943 31.1704 0.0218411C32.2047 0.110776 33.2063 0.469659 34.0955 1.06993C34.9846 1.67021 35.7367 2.4953 36.292 3.47957C36.8474 4.46383 37.1905 5.5801 37.2942 6.73956C37.3979 7.89901 37.2592 9.06965 36.8893 10.1583C36.5193 11.247 35.9283 12.2236 35.1632 13.0106C36.976 13.8923 38.5519 15.2914 39.7344 17.069C39.8394 17.2268 39.9157 17.4062 39.9589 17.5971C40.0021 17.7881 40.0114 17.9867 39.9861 18.1816C39.9609 18.3765 39.9017 18.564 39.8119 18.7331C39.722 18.9023 39.6034 19.0499 39.4627 19.1675ZM30.4837 30.699C30.5802 30.8694 30.645 31.06 30.6741 31.2593C30.7033 31.4587 30.6963 31.6625 30.6535 31.8587C30.6108 32.0549 30.5331 32.2393 30.4252 32.4009C30.3174 32.5625 30.1815 32.6979 30.0258 32.799C29.8702 32.9001 29.6979 32.9647 29.5194 32.9891C29.3409 33.0134 29.1599 32.997 28.9872 32.9407C28.8145 32.8844 28.6537 32.7895 28.5146 32.6616C28.3754 32.5337 28.2607 32.3755 28.1773 32.1966C27.3375 30.5992 26.1414 29.2753 24.7071 28.3556C23.2728 27.436 21.6498 26.9523 19.9982 26.9523C18.3467 26.9523 16.7237 27.436 15.2894 28.3556C13.8551 29.2753 12.659 30.5992 11.8192 32.1966C11.7358 32.3755 11.6211 32.5337 11.4819 32.6616C11.3428 32.7895 11.182 32.8844 11.0093 32.9407C10.8366 32.997 10.6556 33.0134 10.4771 32.9891C10.2986 32.9647 10.1263 32.9001 9.97068 32.799C9.81501 32.6979 9.67915 32.5625 9.57127 32.4009C9.4634 32.2393 9.38573 32.0549 9.34296 31.8587C9.30018 31.6625 9.29317 31.4587 9.32235 31.2593C9.35153 31.06 9.4163 30.8694 9.51277 30.699C10.8053 28.2043 12.7761 26.2412 15.1355 25.098C13.8078 23.9562 12.8321 22.3757 12.3454 20.5787C11.8588 18.7817 11.8857 16.8586 12.4223 15.0797C12.9589 13.3008 13.9783 11.7555 15.3372 10.661C16.6961 9.56653 18.3262 8.97793 19.9982 8.97793C21.6703 8.97793 23.3004 9.56653 24.6593 10.661C26.0182 11.7555 27.0376 13.3008 27.5742 15.0797C28.1108 16.8586 28.1377 18.7817 27.6511 20.5787C27.1644 22.3757 26.1887 23.9562 24.861 25.098C27.2204 26.2412 29.1912 28.2043 30.4837 30.699ZM19.9982 23.9598C21.053 23.9598 22.084 23.6085 22.961 22.9503C23.8379 22.292 24.5214 21.3565 24.9251 20.2619C25.3287 19.1673 25.4343 17.9628 25.2285 16.8008C25.0228 15.6388 24.5149 14.5714 23.7691 13.7336C23.0233 12.8959 22.0731 12.3253 21.0386 12.0942C20.0042 11.8631 18.9319 11.9817 17.9575 12.4351C16.9831 12.8885 16.1502 13.6563 15.5642 14.6414C14.9783 15.6265 14.6655 16.7847 14.6655 17.9695C14.6655 19.5582 15.2274 21.0819 16.2274 22.2053C17.2275 23.3287 18.5839 23.9598 19.9982 23.9598ZM10.666 13.4767C10.666 13.0795 10.5255 12.6986 10.2755 12.4177C10.0255 12.1369 9.68637 11.9791 9.33279 11.9791C8.58475 11.979 7.85173 11.7433 7.21697 11.2987C6.58222 10.8541 6.07118 10.2185 5.74191 9.46398C5.41264 8.70949 5.27833 7.86638 5.35423 7.03044C5.43014 6.19449 5.71322 5.39921 6.17132 4.73493C6.62942 4.07065 7.24418 3.564 7.94577 3.27252C8.64736 2.98105 9.40766 2.91643 10.1403 3.08601C10.8729 3.25559 11.5486 3.65257 12.0904 4.23187C12.6323 4.81116 13.0187 5.54954 13.2057 6.36314C13.2941 6.74792 13.5149 7.07749 13.8196 7.27935C14.1243 7.48121 14.488 7.53883 14.8305 7.43954C15.173 7.34024 15.4664 7.09216 15.6461 6.74987C15.8258 6.40758 15.8771 5.99912 15.7887 5.61435C15.5292 4.48613 15.0388 3.44153 14.3566 2.56367C13.6744 1.6858 12.8192 0.998911 11.8591 0.557641C10.899 0.116372 9.86044 -0.0670943 8.82611 0.0218411C7.79177 0.110776 6.79019 0.469659 5.90105 1.06993C5.01191 1.67021 4.25977 2.4953 3.70446 3.47957C3.14914 4.46383 2.806 5.5801 2.70232 6.73956C2.59863 7.89901 2.73728 9.06965 3.10723 10.1583C3.47717 11.247 4.0682 12.2236 4.83329 13.0106C3.0223 13.8931 1.4482 15.2922 0.267142 17.069C0.054772 17.3868 -0.0365323 17.7863 0.0133155 18.1797C0.0631633 18.573 0.25008 18.928 0.532946 19.1666C0.815811 19.4052 1.17146 19.5077 1.52164 19.4517C1.87182 19.3957 2.18786 19.1858 2.40023 18.868C3.20379 17.6547 4.24972 16.6703 5.45382 15.994C6.65793 15.3177 7.98657 14.9684 9.33279 14.9743C9.68637 14.9743 10.0255 14.8165 10.2755 14.5357C10.5255 14.2548 10.666 13.8739 10.666 13.4767Z" fill="currentColor"/>
    </symbol>
    <symbol id="messages" viewBox="0 0 34 29" fill="none">
        <path d="M30.3333 2H3.66667C2.74619 2 2 2.79949 2 3.78571V25.2143C2 26.2005 2.74619 27 3.66667 27H30.3333C31.2538 27 32 26.2005 32 25.2143V3.78571C32 2.79949 31.2538 2 30.3333 2Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M30.3337 2.89294L17.0003 16.2858L3.66699 2.89294" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="appointments" viewBox="0 0 37 37" fill="none">
        <path d="M31.4989 5.30005H5.68736C3.65089 5.30005 2 6.77751 2 8.60004V31.7C2 33.5225 3.65089 35 5.68736 35H31.4989C33.5354 35 35.1863 33.5225 35.1863 31.7V8.60004C35.1863 6.77751 33.5354 5.30005 31.4989 5.30005Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M25.968 2V8.59999" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M11.2185 2V8.59999" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M2 15.2001H35.1863" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="projects" viewBox="0 0 40 37">
        <path d="M40 0.625H0V11.875H2V32.5C2 34.5719 3.79 36.25 6 36.25H34C36.21 36.25 38 34.5719 38 32.5V11.875H40V0.625ZM4 4.375H36V8.125H4V4.375ZM34 32.5H6V11.875H34V32.5ZM14 15.625H26C26 17.6969 24.21 19.375 22 19.375H18C15.79 19.375 14 17.6969 14 15.625Z" fill="currentColor"/>
    </symbol>
    <symbol id="settings" viewBox="0 0 42 40">
        <path d="M21.0001 11C19.2201 11 17.48 11.5278 16 12.5168C14.5199 13.5057 13.3664 14.9113 12.6852 16.5558C12.004 18.2004 11.8258 20.01 12.173 21.7558C12.5203 23.5016 13.3775 25.1053 14.6362 26.364C15.8948 27.6226 17.4985 28.4798 19.2443 28.8271C20.9901 29.1743 22.7997 28.9961 24.4443 28.3149C26.0888 27.6337 27.4944 26.4802 28.4833 25.0001C29.4723 23.5201 30.0001 21.78 30.0001 20C29.9976 17.6138 29.0486 15.3261 27.3613 13.6388C25.674 11.9515 23.3863 11.0025 21.0001 11ZM21.0001 26C19.8134 26 18.6534 25.6481 17.6667 24.9888C16.68 24.3295 15.911 23.3925 15.4568 22.2961C15.0027 21.1997 14.8839 19.9933 15.1154 18.8295C15.3469 17.6656 15.9184 16.5965 16.7575 15.7574C17.5966 14.9182 18.6657 14.3468 19.8296 14.1153C20.9935 13.8838 22.1999 14.0026 23.2962 14.4567C24.3926 14.9108 25.3296 15.6799 25.9889 16.6666C26.6482 17.6533 27.0001 18.8133 27.0001 20C27.0001 21.5913 26.368 23.1174 25.2428 24.2426C24.1175 25.3679 22.5914 26 21.0001 26ZM41.6139 16.1019C41.5721 15.8906 41.4853 15.6909 41.3595 15.5162C41.2336 15.3415 41.0716 15.1959 40.8845 15.0894L35.2914 11.9019L35.2689 5.59812C35.2682 5.38102 35.2204 5.16666 35.1288 4.96984C35.0372 4.77301 34.9039 4.59842 34.7382 4.45812C32.7094 2.74193 30.3729 1.42675 27.8532 0.582499C27.6548 0.515336 27.4445 0.490481 27.2359 0.509534C27.0273 0.528587 26.825 0.591126 26.642 0.693124L21.0001 3.84687L15.3526 0.687498C15.1695 0.584927 14.967 0.521915 14.758 0.502537C14.549 0.483158 14.3383 0.507844 14.1395 0.574998C11.6216 1.42542 9.28791 2.74562 7.26199 4.46562C7.09655 4.60572 6.96345 4.78001 6.87185 4.97649C6.78024 5.17297 6.73231 5.38697 6.73136 5.60375L6.70324 11.9131L1.11011 15.1006C0.922991 15.2072 0.760996 15.3527 0.635141 15.5274C0.509285 15.7021 0.422518 15.9019 0.380738 16.1131C-0.131144 18.6854 -0.131144 21.3333 0.380738 23.9056C0.422518 24.1169 0.509285 24.3166 0.635141 24.4913C0.760996 24.666 0.922991 24.8116 1.11011 24.9181L6.70324 28.1056L6.72574 34.4094C6.72642 34.6265 6.77421 34.8408 6.86583 35.0377C6.95744 35.2345 7.09069 35.4091 7.25636 35.5494C9.28525 37.2656 11.6217 38.5808 14.1414 39.425C14.3398 39.4922 14.5501 39.517 14.7587 39.498C14.9673 39.4789 15.1696 39.4164 15.3526 39.3144L21.0001 36.1531L26.6476 39.3125C26.8711 39.437 27.123 39.5016 27.3789 39.5C27.5427 39.4999 27.7054 39.4733 27.8607 39.4212C30.3783 38.572 32.712 37.253 34.7382 35.5344C34.9037 35.3943 35.0368 35.22 35.1284 35.0235C35.22 34.827 35.2679 34.613 35.2689 34.3962L35.297 28.0869L40.8901 24.8994C41.0772 24.7928 41.2392 24.6473 41.3651 24.4726C41.4909 24.2979 41.5777 24.0981 41.6195 23.8869C42.1285 21.3166 42.1266 18.6714 41.6139 16.1019ZM38.8014 22.6475L33.4445 25.6944C33.2098 25.8278 33.0154 26.0222 32.882 26.2569C32.7732 26.4444 32.6589 26.6431 32.5426 26.8306C32.3938 27.0671 32.3145 27.3406 32.3139 27.62L32.2857 33.6669C30.8459 34.7976 29.2418 35.7018 27.5289 36.3481L22.1251 33.3369C21.9008 33.2127 21.6484 33.1482 21.392 33.1494H21.3564C21.1295 33.1494 20.9007 33.1494 20.6739 33.1494C20.4055 33.1427 20.1402 33.2074 19.9051 33.3369L14.4976 36.3556C12.7811 35.7142 11.1725 34.8145 9.72761 33.6875L9.70699 27.65C9.70606 27.3701 9.62683 27.096 9.47824 26.8587C9.36199 26.6712 9.24761 26.4837 9.14074 26.285C9.00822 26.0467 8.8139 25.8485 8.57824 25.7113L3.21574 22.6569C2.93824 20.9015 2.93824 19.1135 3.21574 17.3581L8.56324 14.3056C8.79795 14.1722 8.99228 13.9778 9.12574 13.7431C9.23449 13.5556 9.34886 13.3569 9.46511 13.1694C9.61392 12.9329 9.69319 12.6594 9.69386 12.38L9.72199 6.33312C11.1619 5.2024 12.766 4.29822 14.4789 3.65187L19.8751 6.66312C20.11 6.7933 20.3755 6.85806 20.6439 6.85062C20.8707 6.85062 21.0995 6.85062 21.3264 6.85062C21.5947 6.85733 21.86 6.79262 22.0951 6.66312L27.5026 3.64437C29.2192 4.28576 30.8277 5.18551 32.2726 6.3125L32.2932 12.35C32.2942 12.6299 32.3734 12.904 32.522 13.1412C32.6382 13.3287 32.7526 13.5162 32.8595 13.715C32.992 13.9533 33.1863 14.1515 33.422 14.2887L38.7845 17.3431C39.0657 19.0998 39.0689 20.8898 38.7939 22.6475H38.8014Z" fill="currentColor"/>
    </symbol>
    <symbol id="admin" viewBox="0 0 40 46">
        <g clip-path="url(#clip0_3_760)">
        <path d="M22.5 14.375C22.5 13.9938 22.6317 13.6281 22.8661 13.3585C23.1005 13.089 23.4185 12.9375 23.75 12.9375H38.75C39.0815 12.9375 39.3994 13.089 39.6339 13.3585C39.8683 13.6281 40 13.9938 40 14.375C40 14.7563 39.8683 15.1219 39.6339 15.3915C39.3994 15.6611 39.0815 15.8125 38.75 15.8125H23.75C23.4185 15.8125 23.1005 15.6611 22.8661 15.3915C22.6317 15.1219 22.5 14.7563 22.5 14.375ZM38.75 21.5625H23.75C23.4185 21.5625 23.1005 21.714 22.8661 21.9835C22.6317 22.2531 22.5 22.6188 22.5 23C22.5 23.3813 22.6317 23.7469 22.8661 24.0165C23.1005 24.2861 23.4185 24.4375 23.75 24.4375H38.75C39.0815 24.4375 39.3994 24.2861 39.6339 24.0165C39.8683 23.7469 40 23.3813 40 23C40 22.6188 39.8683 22.2531 39.6339 21.9835C39.3994 21.714 39.0815 21.5625 38.75 21.5625ZM38.75 30.1875H27.5C27.1685 30.1875 26.8505 30.339 26.6161 30.6085C26.3817 30.8781 26.25 31.2438 26.25 31.625C26.25 32.0063 26.3817 32.3719 26.6161 32.6415C26.8505 32.9111 27.1685 33.0625 27.5 33.0625H38.75C39.0815 33.0625 39.3994 32.9111 39.6339 32.6415C39.8683 32.3719 40 32.0063 40 31.625C40 31.2438 39.8683 30.8781 39.6339 30.6085C39.3994 30.339 39.0815 30.1875 38.75 30.1875ZM23.7109 34.1406C23.7518 34.3235 23.7609 34.5138 23.7378 34.7008C23.7147 34.8877 23.6598 35.0676 23.5762 35.2301C23.4926 35.3926 23.382 35.5346 23.2507 35.648C23.1194 35.7614 22.97 35.8439 22.8109 35.8908C22.709 35.9224 22.6039 35.9381 22.4984 35.9375C22.2212 35.9377 21.9518 35.8318 21.7326 35.6367C21.5134 35.4415 21.3568 35.1681 21.2875 34.8594C20.325 30.5577 16.5469 27.3125 12.4984 27.3125C8.44998 27.3125 4.67185 30.5559 3.70935 34.8594C3.62647 35.2287 3.41941 35.5451 3.13371 35.7388C2.84801 35.9326 2.50708 35.9879 2.18592 35.8926C1.86476 35.7973 1.58967 35.5591 1.42118 35.2306C1.25269 34.902 1.2046 34.51 1.28748 34.1406C2.16092 30.2396 4.69998 27.0807 7.92185 25.5156C6.68128 24.4168 5.7709 22.8989 5.31839 21.175C4.86588 19.451 4.89395 17.6074 5.39864 15.9027C5.90334 14.198 6.85936 12.7177 8.13262 11.6695C9.40587 10.6212 10.9325 10.0575 12.4984 10.0575C14.0643 10.0575 15.591 10.6212 16.8642 11.6695C18.1375 12.7177 19.0935 14.198 19.5982 15.9027C20.1029 17.6074 20.131 19.451 19.6784 21.175C19.2259 22.8989 18.3156 24.4168 17.075 25.5156C20.2984 27.0807 22.8375 30.2396 23.7109 34.1406ZM12.5 24.4375C13.4889 24.4375 14.4556 24.1003 15.2778 23.4685C16.1001 22.8366 16.7409 21.9386 17.1194 20.8879C17.4978 19.8373 17.5968 18.6811 17.4039 17.5657C17.211 16.4503 16.7348 15.4258 16.0355 14.6216C15.3363 13.8175 14.4453 13.2699 13.4754 13.048C12.5055 12.8261 11.5002 12.94 10.5866 13.3752C9.67293 13.8104 8.89204 14.5474 8.34263 15.493C7.79322 16.4386 7.49998 17.5503 7.49998 18.6875C7.49998 20.2125 8.02676 21.675 8.96444 22.7534C9.90213 23.8317 11.1739 24.4375 12.5 24.4375Z" fill="currentColor"/>
        </g>
        <defs>
        <clipPath id="clip0_3_760">
        <rect width="40" height="46" fill="white"/>
        </clipPath>
        </defs>
    </symbol>
    <symbol id="ticket" viewBox="0 0 22 22" fill="none">
        <path d="M19.4615 1H2.53846C2.13044 1 1.73912 1.18323 1.4506 1.50939C1.16209 1.83555 1 2.27791 1 2.73917V20.1309C1.00007 20.2791 1.03365 20.4248 1.09755 20.5542C1.16145 20.6837 1.25355 20.7925 1.3651 20.8703C1.47666 20.9482 1.60397 20.9925 1.73494 20.9991C1.86592 21.0057 1.99622 20.9744 2.11346 20.9081L4.84615 19.3635L7.57885 20.9081C7.68572 20.9685 7.80357 21 7.92308 21C8.04258 21 8.16044 20.9685 8.26731 20.9081L11 19.3635L13.7327 20.9081C13.8396 20.9685 13.9574 21 14.0769 21C14.1964 21 14.3143 20.9685 14.4212 20.9081L17.1538 19.3635L19.8865 20.9081C20.0038 20.9744 20.1341 21.0057 20.2651 20.9991C20.396 20.9925 20.5233 20.9482 20.6349 20.8703C20.7465 20.7925 20.8386 20.6837 20.9025 20.5542C20.9664 20.4248 20.9999 20.2791 21 20.1309V2.73917C21 2.27791 20.8379 1.83555 20.5494 1.50939C20.2609 1.18323 19.8696 1 19.4615 1ZM19.4615 18.7243L17.4981 17.6134C17.3912 17.553 17.2733 17.5215 17.1538 17.5215C17.0343 17.5215 16.9165 17.553 16.8096 17.6134L14.0769 19.1591L11.3442 17.6134C11.2374 17.553 11.1195 17.5215 11 17.5215C10.8805 17.5215 10.7626 17.553 10.6558 17.6134L7.92308 19.1591L5.19038 17.6134C5.08352 17.553 4.96566 17.5215 4.84615 17.5215C4.72665 17.5215 4.60879 17.553 4.50192 17.6134L2.53846 18.7243V2.73917H19.4615V18.7243ZM11.7692 8.82627C11.7692 8.59564 11.8503 8.37446 11.9945 8.21138C12.1388 8.0483 12.3344 7.95668 12.5385 7.95668H17.1538C17.3579 7.95668 17.5535 8.0483 17.6978 8.21138C17.842 8.37446 17.9231 8.59564 17.9231 8.82627C17.9231 9.0569 17.842 9.27808 17.6978 9.44116C17.5535 9.60424 17.3579 9.69585 17.1538 9.69585H12.5385C12.3344 9.69585 12.1388 9.60424 11.9945 9.44116C11.8503 9.27808 11.7692 9.0569 11.7692 8.82627ZM11.7692 12.3046C11.7692 12.074 11.8503 11.8528 11.9945 11.6897C12.1388 11.5266 12.3344 11.435 12.5385 11.435H17.1538C17.3579 11.435 17.5535 11.5266 17.6978 11.6897C17.842 11.8528 17.9231 12.074 17.9231 12.3046C17.9231 12.5352 17.842 12.7564 17.6978 12.9195C17.5535 13.0826 17.3579 13.1742 17.1538 13.1742H12.5385C12.3344 13.1742 12.1388 13.0826 11.9945 12.9195C11.8503 12.7564 11.7692 12.5352 11.7692 12.3046ZM4.84615 14.9134H9.46154C9.66555 14.9134 9.86121 14.8218 10.0055 14.6587C10.1497 14.4956 10.2308 14.2744 10.2308 14.0438V7.0871C10.2308 6.85647 10.1497 6.63529 10.0055 6.47221C9.86121 6.30913 9.66555 6.21751 9.46154 6.21751H4.84615C4.64214 6.21751 4.44648 6.30913 4.30223 6.47221C4.15797 6.63529 4.07692 6.85647 4.07692 7.0871V14.0438C4.07692 14.2744 4.15797 14.4956 4.30223 14.6587C4.44648 14.8218 4.64214 14.9134 4.84615 14.9134ZM5.61538 7.95668H8.69231V13.1742H5.61538V7.95668Z" fill="currentColor" stroke="currentColor" stroke-width="0.5"/>
    </symbol>

    {{-- * Profile --}}
    <symbol id="profile-def" viewBox="0 0 32 32" fill="none">
        <path d="M15.6863 0C11.526 0 7.53614 1.64945 4.5944 4.58548C1.65266 7.52152 0 11.5036 0 15.6558C0.000555046 16.1904 0.0296449 16.7247 0.0871459 17.2562C0.494973 21.1016 2.31423 24.6603 5.19441 27.2466C8.07459 29.833 11.8119 31.264 15.6863 31.264C19.5606 31.264 23.2979 29.833 26.1781 27.2466C29.0583 24.6603 30.8776 21.1016 31.2854 17.2562C31.3429 16.7247 31.372 16.1904 31.3725 15.6558C31.3725 11.5036 29.7199 7.52152 26.7781 4.58548C23.8364 1.64945 19.8465 0 15.6863 0ZM25.1329 23.3446C25.1154 23.3446 25.0283 23.4837 25.0109 23.4837C23.8699 24.8451 22.4435 25.9401 20.8324 26.6914C19.2212 27.4427 17.4646 27.8321 15.6863 27.8321C13.9079 27.8321 12.1513 27.4427 10.5401 26.6914C8.92901 25.9401 7.50265 24.8451 6.36165 23.4837C6.34422 23.4837 6.25708 23.3446 6.23965 23.3446C6.14394 23.206 6.08955 23.0431 6.08278 22.8749C6.08603 22.6924 6.14431 22.5151 6.25002 22.3662C6.35573 22.2172 6.50396 22.1035 6.67538 22.0399C7.96514 21.605 9.20261 21.1875 9.55119 21.1006C9.54309 21.0613 9.54357 21.0208 9.55259 20.9818C9.56162 20.9428 9.57897 20.9061 9.60348 20.8744C9.64918 20.706 9.74555 20.5557 9.87957 20.4437C10.0136 20.3317 10.1788 20.2635 10.3529 20.2482L12.5664 20.0742C12.5478 19.5989 12.4352 19.1319 12.2353 18.7V18.6826C12.0485 18.1912 11.7837 17.7331 11.451 17.3258C10.5395 16.1391 10.0545 14.6808 10.0741 13.1857C9.97767 11.6481 10.4898 10.1343 11.5002 8.96965C12.5106 7.80504 13.9386 7.08276 15.4771 6.95814H15.8954C17.4339 7.08276 18.8619 7.80504 19.8723 8.96965C20.8828 10.1343 21.3949 11.6481 21.2985 13.1857C21.318 14.6808 20.833 16.1391 19.9216 17.3258C19.5888 17.7331 19.324 18.1912 19.1372 18.6826V18.7C18.9373 19.1319 18.8247 19.5989 18.8061 20.0742L21.0196 20.2482C21.1937 20.2635 21.3589 20.3317 21.493 20.4437C21.627 20.5557 21.7233 20.706 21.769 20.8744C21.7936 20.9061 21.8109 20.9428 21.8199 20.9818C21.829 21.0208 21.8294 21.0613 21.8213 21.1006C22.1699 21.1875 23.4074 21.605 24.6971 22.0399C24.8249 22.0808 24.9413 22.1512 25.0367 22.2454C25.1321 22.3396 25.204 22.4549 25.2464 22.582C25.2889 22.7091 25.3007 22.8443 25.281 22.9768C25.2612 23.1093 25.2105 23.2353 25.1329 23.3446Z" fill="white"/>
    </symbol>



    {{-- **** For BUTTONS **** --}}
    {{-- * View --}}
    <symbol id="view" viewBox="0 0 18 16">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M3 0C2.17157 0 1.5 0.671573 1.5 1.5V2.25C1.5 2.2925 1.50177 2.33458 1.50523 2.37619C0.628606 2.68358 0 3.51838 0 4.5V13.5C0 14.7426 1.00736 15.75 2.25 15.75H15.75C16.9926 15.75 18 14.7426 18 13.5V4.5C18 3.25736 16.9926 2.25 15.75 2.25H8.90549C8.57245 0.95608 7.39788 0 6 0H3ZM7.29933 2.25C7.03997 1.80165 6.55521 1.5 6 1.5H3V2.25H7.29933ZM2.25 3.75C1.83579 3.75 1.5 4.08579 1.5 4.5V13.5C1.5 13.9142 1.83579 14.25 2.25 14.25H15.75C16.1642 14.25 16.5 13.9142 16.5 13.5V4.5C16.5 4.08579 16.1642 3.75 15.75 3.75H2.25Z" fill="currentColor"/>
        <path d="M5.07809 8.86624C5.02666 8.98683 5 9.11837 5 9.25152C5 9.38468 5.02666 9.51621 5.07809 9.63681C5.93031 11.6119 7.24722 12.628 8.99988 12.628C10.7525 12.628 12.0694 11.6098 12.9217 9.63681C13.0258 9.39336 13.0258 9.11181 12.9236 8.86836L12.9217 8.86624L12.9197 8.86412C12.0694 6.89113 10.7525 5.875 8.99988 5.875C7.24722 5.875 5.93031 6.89325 5.07809 8.86624ZM8.99988 7.22984C10.1972 7.22984 11.0707 7.86493 11.7205 9.25152C11.0726 10.6381 10.1972 11.2732 8.99988 11.2732C7.80252 11.2732 6.92908 10.6381 6.2793 9.25152C6.92908 7.86493 7.80252 7.22984 8.99988 7.22984Z" fill="currentColor"/>
        <path d="M7.92981 9.2619C7.92981 9.57632 8.04357 9.87785 8.24606 10.1002C8.44855 10.3225 8.72319 10.4474 9.00956 10.4474C9.29592 10.4474 9.57056 10.3225 9.77305 10.1002C9.97554 9.87785 10.0893 9.57632 10.0893 9.2619C10.0893 8.94749 9.97554 8.64596 9.77305 8.42364C9.57056 8.20132 9.29592 8.07642 9.00956 8.07642C8.72319 8.07642 8.44855 8.20132 8.24606 8.42364C8.04357 8.64596 7.92981 8.94749 7.92981 9.2619Z" fill="currentColor"/>
    </symbol>
    {{-- * Edit --}}
    <symbol id="edit" viewBox="0 0 15 15">
        <path d="M14.5894 3.53638L11.4345 0.38219C11.3297 0.277277 11.2051 0.194054 11.0681 0.137274C10.931 0.080494 10.7841 0.0512695 10.6358 0.0512695C10.4874 0.0512695 10.3405 0.080494 10.2034 0.137274C10.0664 0.194054 9.94186 0.277277 9.83697 0.38219L1.13188 9.08728C1.02654 9.19179 0.943018 9.31619 0.886178 9.45326C0.829339 9.59033 0.800313 9.73733 0.800787 9.88571V13.0406C0.800787 13.3402 0.91979 13.6275 1.13162 13.8393C1.34344 14.0511 1.63074 14.1701 1.93031 14.1701H13.7903C13.9401 14.1701 14.0837 14.1106 14.1896 14.0047C14.2956 13.8988 14.3551 13.7552 14.3551 13.6054C14.3551 13.4556 14.2956 13.3119 14.1896 13.206C14.0837 13.1001 13.9401 13.0406 13.7903 13.0406H6.68278L14.5894 5.13395C14.6944 5.02906 14.7776 4.90453 14.8344 4.76748C14.8911 4.63042 14.9204 4.48352 14.9204 4.33517C14.9204 4.18681 14.8911 4.03991 14.8344 3.90286C14.7776 3.7658 14.6944 3.64127 14.5894 3.53638ZM5.08521 13.0406H1.93031V9.88571L8.14269 3.67334L11.2976 6.82824L5.08521 13.0406ZM12.096 6.02981L8.94182 2.87491L10.6361 1.18062L13.7903 4.33552L12.096 6.02981Z" fill="currentColor"/>
    </symbol>
    {{-- * Trash --}}
    <symbol id="trash" viewBox="0 0 15 16">
        <path d="M13.8521 3.17301H1.37687C1.22648 3.17301 1.08225 3.23276 0.975902 3.3391C0.869558 3.44545 0.809814 3.58968 0.809814 3.74007C0.809814 3.89046 0.869558 4.0347 0.975902 4.14104C1.08225 4.24739 1.22648 4.30713 1.37687 4.30713H1.94393V14.5142C1.94393 14.8149 2.06342 15.1034 2.2761 15.3161C2.48879 15.5288 2.77726 15.6483 3.07804 15.6483H12.151C12.4517 15.6483 12.7402 15.5288 12.9529 15.3161C13.1656 15.1034 13.2851 14.8149 13.2851 14.5142V4.30713H13.8521C14.0025 4.30713 14.1468 4.24739 14.2531 4.14104C14.3594 4.0347 14.4192 3.89046 14.4192 3.74007C14.4192 3.58968 14.3594 3.44545 14.2531 3.3391C14.1468 3.23276 14.0025 3.17301 13.8521 3.17301ZM12.151 14.5142H3.07804V4.30713H12.151V14.5142ZM4.21216 1.47184C4.21216 1.32145 4.2719 1.17722 4.37825 1.07087C4.48459 0.964529 4.62882 0.904785 4.77922 0.904785H10.4498C10.6002 0.904785 10.7444 0.964529 10.8508 1.07087C10.9571 1.17722 11.0168 1.32145 11.0168 1.47184C11.0168 1.62224 10.9571 1.76647 10.8508 1.87281C10.7444 1.97916 10.6002 2.0389 10.4498 2.0389H4.77922C4.62882 2.0389 4.48459 1.97916 4.37825 1.87281C4.2719 1.76647 4.21216 1.62224 4.21216 1.47184Z" fill="currentColor"/>
    </symbol>
    {{-- * Add --}}
    <symbol id="add" viewBox="0 0 20 21">
        <path d="M18.2794 0.970581H2.34802C1.92549 0.970581 1.52027 1.13843 1.2215 1.4372C0.922731 1.73597 0.754883 2.14119 0.754883 2.56372V18.4951C0.754883 18.9176 0.922731 19.3228 1.2215 19.6216C1.52027 19.9204 1.92549 20.0882 2.34802 20.0882H18.2794C18.7019 20.0882 19.1071 19.9204 19.4059 19.6216C19.7047 19.3228 19.8725 18.9176 19.8725 18.4951V2.56372C19.8725 2.14119 19.7047 1.73597 19.4059 1.4372C19.1071 1.13843 18.7019 0.970581 18.2794 0.970581ZM18.2794 18.4951H2.34802V2.56372H18.2794V18.4951ZM15.0931 10.5294C15.0931 10.7407 15.0092 10.9433 14.8598 11.0927C14.7104 11.242 14.5078 11.326 14.2965 11.326H11.1103V14.5122C11.1103 14.7235 11.0264 14.9261 10.877 15.0755C10.7276 15.2249 10.525 15.3088 10.3137 15.3088C10.1024 15.3088 9.89983 15.2249 9.75045 15.0755C9.60106 14.9261 9.51714 14.7235 9.51714 14.5122V11.326H6.33086C6.1196 11.326 5.91699 11.242 5.7676 11.0927C5.61822 10.9433 5.53429 10.7407 5.53429 10.5294C5.53429 10.3181 5.61822 10.1155 5.7676 9.96615C5.91699 9.81676 6.1196 9.73284 6.33086 9.73284H9.51714V6.54656C9.51714 6.3353 9.60106 6.13269 9.75045 5.9833C9.89983 5.83392 10.1024 5.74999 10.3137 5.74999C10.525 5.74999 10.7276 5.83392 10.877 5.9833C11.0264 6.13269 11.1103 6.3353 11.1103 6.54656V9.73284H14.2965C14.5078 9.73284 14.7104 9.81676 14.8598 9.96615C15.0092 10.1155 15.0931 10.3181 15.0931 10.5294Z" fill="currentColor"/>
    </symbol>
    {{-- * Export --}}
    <symbol id="export" viewBox="0 0 30 36">
        <path d="M23.0739 8.60328L20.7981 10.879L16.7179 6.7988V26.4239H13.4995V6.79891L9.41942 10.879L7.14367 8.60328L15.1088 0.638184L23.0739 8.60328Z" fill="currentColor"/>
        <path d="M3.84436 32.7639V16.6719H10.2811V13.4536H0.625977V35.9823H29.5914V13.4536H19.9363V16.6719H26.373V32.7639H3.84436Z" fill="currentColor"/>
    </symbol>



    {{-- **** Arrows **** --}}
    <symbol id="arrow-left" viewBox="0 0 33 29">
        <path d="M15.9021 0.806303C16.6994 1.60362 16.6994 2.89634 15.9021 3.69366L7.13743 12.4583H30.7917C31.9193 12.4583 32.8334 13.3724 32.8334 14.5C32.8334 15.6276 31.9193 16.5416 30.7917 16.5416H7.13743L15.9021 25.3063C16.6994 26.1036 16.6994 27.3963 15.9021 28.1937C15.1048 28.991 13.8121 28.991 13.0147 28.1937L0.764738 15.9437C0.381852 15.5608 0.166748 15.0415 0.166748 14.5C0.166748 13.9585 0.381852 13.4392 0.764738 13.0563L13.0147 0.806303C13.8121 0.00898288 15.1048 0.00898288 15.9021 0.806303Z" fill="currentColor"/>
    </symbol>

    {{-- **** Eyes **** --}}
    {{-- * Eyes Open --}}
    <symbol id="eye-open" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" color="currentColor"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" color="currentColor"/>
    </symbol>
    {{-- * Eyes Close --}}
    <symbol id="eye-close" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
    </symbol>

    {{-- * Attachment --}}
    <symbol id="attachment" viewBox="0 0 21 22" fill="none">
        <path d="M19.2049 10.0491L10.598 18.656C9.54367 19.7105 8.11358 20.3028 6.62242 20.3028C5.13126 20.3028 3.70118 19.7105 2.64677 18.656C1.59236 17.6016 1 16.1715 1 14.6804C1 13.1892 1.59236 11.7592 2.64677 10.7047L11.2536 2.09784C11.9566 1.39491 12.91 1 13.9041 1C14.8982 1 15.8516 1.39491 16.5545 2.09784C17.2575 2.80079 17.6524 3.75418 17.6524 4.74828C17.6524 5.74239 17.2575 6.69578 16.5545 7.39871L7.93828 16.0056C7.58681 16.3571 7.1101 16.5545 6.61306 16.5545C6.116 16.5545 5.63931 16.3571 5.28784 16.0056C4.93637 15.6541 4.73891 15.1775 4.73891 14.6804C4.73891 14.1833 4.93637 13.7066 5.28784 13.3551L13.2391 5.41323" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>

    {{-- * Donwloads --}}
    <symbol id="download" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
    </symbol>

    {{-- * Info-circle --}}
    <symbol id="info-circle" viewBox="0 0 19 19" fill="none">
        <path d="M9.14104 0C4.09294 0 0 4.09441 0 9.14104C0 14.1906 4.09294 18.2821 9.14104 18.2821C14.1891 18.2821 18.2821 14.1906 18.2821 9.14104C18.2821 4.09441 14.1891 0 9.14104 0ZM9.14104 4.05449C9.99602 4.05449 10.6891 4.74759 10.6891 5.60257C10.6891 6.45755 9.99602 7.15065 9.14104 7.15065C8.28605 7.15065 7.59296 6.45755 7.59296 5.60257C7.59296 4.74759 8.28605 4.05449 9.14104 4.05449ZM11.2051 13.4167C11.2051 13.6609 11.0071 13.859 10.7628 13.859H7.51924C7.27497 13.859 7.07693 13.6609 7.07693 13.4167V12.5321C7.07693 12.2878 7.27497 12.0898 7.51924 12.0898H7.96155V9.73078H7.51924C7.27497 9.73078 7.07693 9.53274 7.07693 9.28847V8.40385C7.07693 8.15959 7.27497 7.96155 7.51924 7.96155H9.87822C10.1225 7.96155 10.3205 8.15959 10.3205 8.40385V12.0898H10.7628C11.0071 12.0898 11.2051 12.2878 11.2051 12.5321V13.4167Z" fill="currentColor"/>
    </symbol>

    {{-- * Send Arrow --}}
    <symbol id="send" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
        <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
    </symbol>

</svg>

@php
$classes = ($active ?? false)
            ? 'fill-red w-6 '
            : 'fill-red w-6';
@endphp

<svg {{ $attributes->merge(['class' => 'w-6 h-6']) }}>
    <use xlink:href="#{{ $name }}" />
</svg>
