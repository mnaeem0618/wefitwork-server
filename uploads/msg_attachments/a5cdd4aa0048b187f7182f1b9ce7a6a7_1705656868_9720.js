import {
    SEND_CHAT,
    SEND_CHAT_SUCCESS,
    SEND_CHAT_FAILED,
    CHANGE_IS_SEND_STATUS,
    GET_CHAT,
    GET_CHAT_SUCCESS,
    GET_CHAT_FAILED,
    GET_CHAT_MESSAGES,
    GET_CHAT_MESSAGES_SUCCESS,
    GET_CHAT_MESSAGES_FAILED,
    RECEIVE_CHAT_MESSAGES,
    RECEIVE_USER_ARR,
    RECEIVE_CHAT_MESSAGES_SIDEBAR_STATUS
} from "../actions/actionTypes";
const initialState = {
    isFormProcessing: false,
    isLoading: false,
    isChatLoading: false,
    isSend: false,
    messages: [],
    users: [],
    member: null,
    chat_screen_id: null,
    user_info: null,
    receive_message_obj: null,
    unread_msgs: null,
    new_user_obj: null,
    sidebar_active_status: null
};

export default function (state = initialState, { type, payload, notification }) {

    switch (type) {
        case SEND_CHAT:
            return {
                ...state,
                isFormProcessing: true,
            };
        case SEND_CHAT_SUCCESS:
            if (payload?.status) {
                return {
                    ...state,
                    isFormProcessing: false,
                    isSend: true
                };
            }
            else {
                return {
                    ...state,
                    isFormProcessing: false,
                };
            }

        case SEND_CHAT_FAILED:
            return {
                ...state,
                isFormProcessing: false,
                error: payload
            };
        case GET_CHAT:
            return {
                ...state,
                isLoading: true,
            };
        case GET_CHAT_SUCCESS:
            return {
                ...state,
                isLoading: false,
                users: payload?.users,
                member: payload?.member,
            };

        case GET_CHAT_FAILED:
            return {
                ...state,
                isLoading: false,
                error: payload
            };
        case GET_CHAT_MESSAGES:
            return {
                ...state,
                isChatLoading: true,
            };
        case GET_CHAT_MESSAGES_SUCCESS:
            return {
                ...state,
                isChatLoading: false,
                messages: payload?.messages,
                chat_screen_id: payload?.chat_screen_id,
                user_info: payload?.user_info,
                users: payload?.users,
                member: payload?.member,
                unread_msgs: payload?.unread_msgs
            };

        case GET_CHAT_MESSAGES_FAILED:
            return {
                ...state,
                isChatLoading: false,
                error: payload
            };
        case CHANGE_IS_SEND_STATUS:
            return {
                ...state,
                isSend: payload,
            };
        case RECEIVE_CHAT_MESSAGES:
            return {
                ...state,
                receive_message_obj: payload,
            };
        case RECEIVE_CHAT_MESSAGES_SIDEBAR_STATUS:
            return {
                ...state,
                sidebar_active_status: payload,
            };
        case RECEIVE_USER_ARR:
            return {
                ...state,
                new_user_obj: payload,
            };
        default:
            return state;
    }
}
