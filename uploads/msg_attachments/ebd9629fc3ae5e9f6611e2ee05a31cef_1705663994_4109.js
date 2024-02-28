import http from "../../helpers/http";
import * as helpers from "../../helpers/api";
import { toast } from "react-toastify";
import { TOAST_SETTINGS } from "../../utils/siteSettings";
import Text from "../../components/common/Text";

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
} from "./actionTypes";


export const getChatUsers = (formData) => (dispatch) => {

    dispatch({
        type: GET_CHAT,
        payload: null
    });
    http
        .post("chat-users", helpers.doObjToFormData(formData))
        .then(({ data }) => {
            if (data.status) {
                dispatch({
                    type: GET_CHAT_SUCCESS,
                    payload: data
                });

            } else {
                toast.error(
                    <Text string={data.msg} parse={true} />,
                    TOAST_SETTINGS
                );
                dispatch({
                    type: GET_CHAT_FAILED,
                    payload: null
                });
            }
        })
        .catch((error) => {
            dispatch({
                type: GET_CHAT_FAILED,
                payload: error
            });
        });
};
export const getUserMessages = (formData) => (dispatch) => {

    dispatch({
        type: GET_CHAT_MESSAGES,
        payload: null
    });
    console.log(formData)
    http
        .post("chat-messages", helpers.doObjToFormData(formData))
        .then(({ data }) => {
            console.log(data)
            if (data.status) {
                dispatch({
                    type: GET_CHAT_MESSAGES_SUCCESS,
                    payload: data
                });

            } else {
                if (data?.login_error !== 1) {
                    toast.error(
                        <Text string={data.msg} parse={true} />,
                        TOAST_SETTINGS
                    );
                }

                dispatch({
                    type: GET_CHAT_MESSAGES_FAILED,
                    payload: null
                });
            }
        })
        .catch((error) => {
            console.log(error)
            dispatch({
                type: GET_CHAT_MESSAGES_FAILED,
                payload: error
            });
        });
};
export const postChatMsg = (formData, redirection = false) => (dispatch) => {
    console.log(formData)
    dispatch({
        type: SEND_CHAT,
        payload: null
    });
    http
        .post("send-chat-msg", helpers.doObjToFormData(formData))
        .then(({ data }) => {
            if (data.status) {
                // toast.success(
                //     `${data.msg}`,
                //     TOAST_SETTINGS
                // );
                if (data?.chat_id !== '' && data?.chat_id !== undefined && data?.chat_id !== null) {
                    setTimeout(() => {
                        window.location.replace("/messages/" + data?.chat_id);
                    }, 1000);
                }
                else {
                    setTimeout(() => {
                        window.location.replace("/messages");
                    }, 1000);
                }
                dispatch({
                    type: SEND_CHAT_SUCCESS,
                    payload: data
                });

            } else {
                toast.error(
                    <Text string={data.msg} parse={true} />,
                    TOAST_SETTINGS
                );
                dispatch({
                    type: SEND_CHAT_FAILED,
                    payload: null
                });
            }
        })
        .catch((error) => {
            dispatch({
                type: SEND_CHAT_FAILED,
                payload: error
            });
        });
};
export const updateIsSendStatus = (newValue) => (dispatch) => {
    dispatch({
        type: CHANGE_IS_SEND_STATUS,
        payload: newValue
    });
};
export const updateMessagesFromReceivedData = (newValue) => (dispatch) => {
    dispatch({
        type: RECEIVE_CHAT_MESSAGES,
        payload: newValue
    });
};
export const updateMessageSidebarStatus = (newValue) => (dispatch) => {
    dispatch({
        type: RECEIVE_CHAT_MESSAGES_SIDEBAR_STATUS,
        payload: newValue
    });
};
export const updateUserArr = (newValue) => (dispatch) => {
    dispatch({
        type: RECEIVE_USER_ARR,
        payload: newValue
    });
};